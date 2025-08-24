<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = auth()->user()
        ->properties()
        ->orderBy('created_at', 'desc')
        ->get();
        // Get only logged-in user's properties
        return view('dashboard', compact('properties'));
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $data = $request->all();
        // If status is NOT leased, clear tenant details
        if ($request->status !== 'Leased') {
            $data['tenant_name'] = null;
            $data['lease_start_date'] = null;
            $data['lease_end_date'] = null;
        }
        $property->update($data);
        return redirect()->route('dashboard')->with('success', 'Property updated successfully.');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
        return redirect()->route('dashboard')->with('success', 'Property deleted successfully.');
    }

    // Show Add Property Form
    public function create()
    {
        return view('properties.create'); // Blade template for form
    }

    // Store Property
    public function store(Request $request)
    {
        $request->validate([
            'property_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
            'type' => 'required|in:House,Apartment,Condo,Land',
            'status' => 'required|in:Available,Leased',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'description' => 'nullable|string',
            'tenant_name' => 'nullable|string|max:255',
            'lease_start_date' => 'nullable|date',
            'lease_end_date' => 'nullable|date',
        ]);

        $property = new Property();
        $property->user_id = auth()->id();
        $property->property_name = $request->property_name;
        $property->address = $request->address;
        $property->price = $request->price;
        $property->type = $request->type;
        $property->status = $request->status;
        $property->bedrooms = $request->bedrooms;
        $property->bathrooms = $request->bathrooms;
        $property->description = $request->description;

        // Only save lease details if status is Leased
        if ($request->status === 'Leased') {
            $property->tenant_name = $request->tenant_name;
            $property->lease_start_date = $request->lease_start_date;
            $property->lease_end_date = $request->lease_end_date;
        }

        $property->save();

        return redirect()->route('dashboard')->with('success', 'Property added successfully.');
    }
}
