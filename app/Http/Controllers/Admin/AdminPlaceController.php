<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class AdminPlaceController extends Controller
{
    public function index()
    {
        $places = Place::orderBy('name')->paginate(20);

        return view('admin.places.index', compact('places'));
    }

    public function create()
    {
        return view('admin.places.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        Place::create($validated);

        return redirect()->route('admin.places.index')->with('success', 'Map place created successfully.');
    }

    public function edit(Place $place)
    {
        return view('admin.places.edit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $place->update($validated);

        return redirect()->route('admin.places.index')->with('success', 'Map place updated successfully.');
    }

    public function destroy(Place $place)
    {
        $place->delete();

        return redirect()->route('admin.places.index')->with('success', 'Map place deleted.');
    }
}
