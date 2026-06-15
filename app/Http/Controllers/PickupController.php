<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function index()
    {
        // Display a list of all pickup points
        $pickups = Pickup::all();
        return view('pickups.index', compact('pickups'));
    }

    /**
     * Show the form for creating a new pickup point.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show form to create a new pickup point
        return view('pickups.create');
    }

    public function store(Request $request)
    {
        // Validate and store the pickup point
        $request->validate([
            'location_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'operating_hours' => 'nullable|string|max:255',
        ]);

        Pickup::create($request->all());

        return redirect()->route('pickups.index')->with('success', 'Pickup location created successfully.');
    }

    public function show(Pickup $pickup)
    {
        // Display a single pickup point
        return view('pickups.show', compact('pickup'));
    }

    public function edit(Pickup $pickup)
    {
        // Show form to edit an existing pickup point
        return view('pickups.edit', compact('pickup'));
    }

    public function update(Request $request, Pickup $pickup)
    {
        // Validate and update the pickup point
        $request->validate([
            'location_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'operating_hours' => 'nullable|string|max:255',
        ]);

        $pickup->update($request->all());

        return redirect()->route('pickups.index')->with('success', 'Pickup location updated successfully.');
    }

    public function destroy(Pickup $pickup)
    {
        // Delete the specified pickup point
        $pickup->delete();
        return redirect()->route('pickups.index')->with('success', 'Pickup location deleted successfully.');
    }
}
