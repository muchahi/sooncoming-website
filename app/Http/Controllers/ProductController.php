<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class ProductController extends Controller
{
  
public function userProducts(Request $request)
{
    $query = Product::where('merchant_id', auth()->id());

    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->has('price_min')) {
        $query->where('price', '>=', $request->price_min);
    }

    if ($request->has('price_max')) {
        $query->where('price', '<=', $request->price_max);
    }

    $products = $query->get();
    $categories = Category::all(); // Fetch all categories

    return view('products.index', compact('products', 'categories'));
}

    public function index(Request $request)
{
    // Get search query, category filter, and price range
    $searchQuery = $request->query('q');
    $categoryFilter = $request->query('c');
    $priceMin = $request->query('price_min');
    $priceMax = $request->query('price_max');

    // Fetch all categories
    $categories = Category::all(); 
   
    // Start product query
    $query = Product::query();

    // If a search query is present, filter by name or description
    if ($searchQuery) {
        $query->where(function ($q) use ($searchQuery) {
            $q->where('name', 'like', '%' . $searchQuery . '%')
              ->orWhere('description', 'like', '%' . $searchQuery . '%');
        });
    }

    // Handle category filtering
    if ($categoryFilter && $categoryFilter !== 'general') {
        $query->where('category_id', $categoryFilter);
    }

    // Handle price filtering
    if ($priceMin) {
        $query->where('price', '>=', $priceMin);
    }

    if ($priceMax) {
        $query->where('price', '<=', $priceMax);
    }

    // Paginate results
    $products = $query->paginate(10);

    return view('products.index', compact('products', 'searchQuery', 'categories'));
}


    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Store a new product
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        Product::create($validated);

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'type_id' => 'required|exists:product_types,id',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'type_id' => $validated['type_id'],
        ]);

        return back()->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product->delete();

        return back()->with('warning', 'Product deleted successfully!');
    }

   public function show($id)
{
    // Fetch the product along with its category
    $product = Product::with('category')->findOrFail($id);

    // Split the product description into an array (assuming new lines are used for each feature)
    $details = explode("\n", $product->description);  // Split by new lines

    // Create a pre-filled WhatsApp message
    $whatsappMessage = urlencode("*{$product->name}*\n*Price:* KSh {$product->price}\n*URL:* " . url("/products/{$id}") . "\n\nThank you!");

    // Generate the WhatsApp link
    $whatsappLink = "https://wa.me/254704136678?text={$whatsappMessage}";  
    $whatsappWebLink = "https://web.whatsapp.com/send?phone=254704136678&text={$whatsappMessage}";  

    // Return the data to the view
    return view('products.show', compact('product', 'whatsappLink', 'whatsappWebLink', 'details'));
}

   public function showProducts(Request $request)
{
    // Get filters from the request
    $categoryFilter = $request->query('c');
    $nameFilter = $request->query('q');

    // Start product query
    $query = Product::query();

    // Apply category filter (excluding 'general')
    if ($categoryFilter && $categoryFilter !== 'general') {
        $query->where('category_id', $categoryFilter);
    }

    // Apply name filter (search by product name)
    if ($nameFilter) {
        $query->where('name', 'like', '%' . $nameFilter . '%');
    }

    // Fetch categories
    $categories = Category::all(); 

    // Fetch 10 random products after filtering
    $products = $query->inRandomOrder()->take(20)->get();

    return view('products.index', compact(['products', 'categories']));
}


    public function uploadImages(Request $request)
    {
        Log::info($request->all());

        $imageNames = [];

        // Process each uploaded file
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                // Generate a unique name for the image
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                Log::info($imageName);

                // Store the image in the public path
                $file->move(public_path('product_images'), $imageName);

                // Store the image name for later use
                $imageNames[] = $imageName;
            }
        }

        return response()->json(['success' => 'Images uploaded successfully.', 'images' => $imageNames]);
    }

    public function storeProductWithImages(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:product_categories,id',
            'type_id' => 'required|exists:product_types,id',
            'location_id' => 'required',
        ]);

        $this_merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $this_category = ProductCategory::where('id', $request->input('category_id'))->first();

        // Create the product
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price') + ($request->input('price') * $this_category->revenue * 0.01);
        $product->stock = $request->input('stock');
        $product->category_id = $request->input('category_id');
        $product->type_id = $request->input('type_id');
        $product->images = json_encode($request->input('image_names'));
        $product->merchant_id = $this_merchant->id ?? 5 or 17;
        $product->location_id = $request->input('location_id');
        $product->save();

        // Handle image names
        if ($request->has('image_names')) {
            $imageNames = explode(',', $request->input('image_names'));

            foreach ($imageNames as $imageName) {
                // Create and save image records
                $image = new Image();
                $image->product_id = $product->id;
                $image->image = $imageName;
                $image->save();
            }
        }

        return back()->with('success', 'Product created successfully!');
    }

    public function AdminIndex()
    {
        $products = Product::with('images')->get(); // Eager load images
        return view('admin.product.index', compact('products'));
    }

    public function AdminEdit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = ProductCategory::all();
        $types = ProductType::all();
        return view('admin.product.edit', compact('product', 'categories', 'types'));
    }
}
