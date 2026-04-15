<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $settings = [
            'platform_name' => SystemSetting::value('platform_name', config('app.name', 'CLIMENTAL')),
            'platform_tagline' => SystemSetting::value('platform_tagline', 'Wellbeing Hub'),
            'map_title' => SystemSetting::value('map_title', 'Masvingo Community Map'),
            'map_default_latitude' => SystemSetting::value('map_default_latitude', '-20.0988'),
            'map_default_longitude' => SystemSetting::value('map_default_longitude', '30.7305'),
            'map_default_zoom' => SystemSetting::value('map_default_zoom', '13'),
            'community_title' => SystemSetting::value('community_title', 'Open social space for the Climental system.'),
            'community_intro' => SystemSetting::value('community_intro', 'Share updates, photos, support moments, and ideas with the wider campus community.'),
            'community_composer_placeholder' => SystemSetting::value('community_composer_placeholder', 'What would you like to share today?'),
            'community_enable_photos' => SystemSetting::value('community_enable_photos', '1'),
            'community_enable_comments' => SystemSetting::value('community_enable_comments', '1'),
            'community_enable_likes' => SystemSetting::value('community_enable_likes', '1'),
            'community_enable_reposts' => SystemSetting::value('community_enable_reposts', '1'),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
            'platform_tagline' => 'nullable|string|max:255',
            'map_title' => 'required|string|max:255',
            'map_default_latitude' => 'required|numeric|between:-90,90',
            'map_default_longitude' => 'required|numeric|between:-180,180',
            'map_default_zoom' => 'required|integer|min:1|max:20',
            'community_title' => 'required|string|max:255',
            'community_intro' => 'nullable|string|max:500',
            'community_composer_placeholder' => 'required|string|max:255',
            'community_enable_photos' => 'nullable|boolean',
            'community_enable_comments' => 'nullable|boolean',
            'community_enable_likes' => 'nullable|boolean',
            'community_enable_reposts' => 'nullable|boolean',
        ]);

        $validated['community_enable_photos'] = $request->boolean('community_enable_photos') ? '1' : '0';
        $validated['community_enable_comments'] = $request->boolean('community_enable_comments') ? '1' : '0';
        $validated['community_enable_likes'] = $request->boolean('community_enable_likes') ? '1' : '0';
        $validated['community_enable_reposts'] = $request->boolean('community_enable_reposts') ? '1' : '0';

        SystemSetting::putMany($validated);

        return redirect()->route('admin.settings.edit')->with('success', 'System settings updated successfully.');
    }
}
