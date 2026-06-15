<?php
use Illuminate\Database\Seeder;
use App\Models\Category;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'All Categories'],
            ['name' => 'SmartWatch'],
            ['name' => 'Mobilephones'],
            ['name' => 'iPads & Tablets'],
            ['name' => 'Laptop & Computer'],
            ['name' => 'Cameras'],
            ['name' => 'Headphones'],
            ['name' => 'Gaming'],
            ['name' => 'Accessories']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
