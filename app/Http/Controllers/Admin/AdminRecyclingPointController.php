<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecyclingPoint;
use Illuminate\Http\Request;

class AdminRecyclingPointController extends Controller
{
    public function index()
    {
        $recyclingPoints = RecyclingPoint::orderBy('name')->paginate(20);

        return view('admin.recycling-points.index', compact('recyclingPoints'));
    }

    public function create()
    {
        return view('admin.recycling-points.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string|max:100',
            'accepted_materials' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        RecyclingPoint::create($validated);

        return redirect()->route('admin.recycling-points.index')->with('success', 'Recycling point created successfully.');
    }

    public function edit(RecyclingPoint $recyclingPoint)
    {
        return view('admin.recycling-points.edit', compact('recyclingPoint'));
    }

    public function update(Request $request, RecyclingPoint $recyclingPoint)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string|max:100',
            'accepted_materials' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $recyclingPoint->update($validated);

        return redirect()->route('admin.recycling-points.index')->with('success', 'Recycling point updated successfully.');
    }

    public function destroy(RecyclingPoint $recyclingPoint)
    {
        $recyclingPoint->delete();

        return redirect()->route('admin.recycling-points.index')->with('success', 'Recycling point deleted.');
    }
}
