<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class AdminOrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::orderBy('name')->paginate(20);
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:clinic,crisis_line,ngo,campus',
            'phone'       => 'nullable|string|max:20',
            'website'     => 'nullable|url',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
        ]);

        Organization::create($request->all());

        return redirect()->route('admin.organizations.index')->with('success', 'Organization added.');
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:clinic,crisis_line,ngo,campus',
            'phone'       => 'nullable|string|max:20',
            'website'     => 'nullable|url',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
        ]);

        $organization->update($request->all());

        return redirect()->route('admin.organizations.index')->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('admin.organizations.index')->with('success', 'Organization deleted.');
    }
}
