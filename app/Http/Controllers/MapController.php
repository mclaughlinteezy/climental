<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Organization; // for clinics that might not be in the places table
use App\Models\RecyclingPoint;
use App\Models\SystemSetting;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $lat = $request->query('lat'); // user's latitude and longitude passed by JS
        $lng = $request->query('lng');

        // Note: For a fully production ready distance calculation in MySQL:
        // We could use the Haversine formula via DB::raw:
        // ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance

        $query = Place::query();

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $places = $query->get();

        // Include Organizations (Clinics)
        if ($category === 'all' || $category === 'clinic') {
            $orgs = Organization::whereNotNull('latitude')->get();
            foreach ($orgs as $org) {
                $places->push((object)[
                    'id' => 'org_' . $org->id,
                    'name' => $org->name,
                    'category' => $org->type, // e.g. clinic
                    'latitude' => $org->latitude,
                    'longitude' => $org->longitude,
                    'description' => $org->description,
                ]);
            }
        }

        // Include RecyclingPoints
        if ($category === 'all' || $category === 'climate') {
            $recyclingPoints = RecyclingPoint::whereNotNull('latitude')->get();
            foreach ($recyclingPoints as $rp) {
                $places->push((object)[
                    'id' => 'rp_' . $rp->id,
                    'name' => $rp->name,
                    'category' => 'recycling_point',
                    'latitude' => $rp->latitude,
                    'longitude' => $rp->longitude,
                    'description' => 'Recycling point: ' . ($rp->accepted_materials ?? 'General'),
                ]);
            }
        }

        $mapConfig = [
            'title' => SystemSetting::value('map_title', 'Masvingo Community Map'),
            'default_latitude' => (float) SystemSetting::value('map_default_latitude', '-20.0988'),
            'default_longitude' => (float) SystemSetting::value('map_default_longitude', '30.7305'),
            'default_zoom' => (int) SystemSetting::value('map_default_zoom', '13'),
        ];

        return view('map.index', compact('places', 'category', 'lat', 'lng', 'mapConfig'));
    }
}
