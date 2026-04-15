<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClimateArticle;
use App\Models\RecyclingPoint;
use App\Models\Campaign;
use App\Models\Club;
use Illuminate\Support\Collection;

class ClimateController extends Controller
{
    private function environmentalClubCatalog(): array
    {
        return [
            [
                'name' => 'Nature Guardians',
                'slug' => 'nature-guardians',
                'description' => 'Students leading tree planting, environmental education, and practical conservation activities on and around campus.',
                'club_points' => 1250,
                'activities' => 'Planting trees, education, conservation',
            ],
            [
                'name' => 'Green Voices',
                'slug' => 'green-voices',
                'description' => 'A creative space for poetry, drama, and awareness campaigns that inspire climate action through storytelling.',
                'club_points' => 900,
                'activities' => 'Poetry, drama, awareness',
            ],
        ];
    }

    private function environmentalClubs(): Collection
    {
        foreach ($this->environmentalClubCatalog() as $club) {
            Club::updateOrCreate(
                ['slug' => $club['slug']],
                [
                    'name' => $club['name'],
                    'description' => $club['description'],
                    'club_points' => $club['club_points'],
                ]
            );
        }

        $activityMap = collect($this->environmentalClubCatalog())->keyBy('slug');

        return Club::withCount('members')
            ->with('members')
            ->whereIn('slug', $activityMap->keys())
            ->get()
            ->sortBy(fn (Club $club) => array_search($club->slug, $activityMap->keys()->all(), true))
            ->values()
            ->map(function (Club $club) use ($activityMap) {
                $club->activities = $activityMap[$club->slug]['activities'];
                return $club;
            });
    }

    public function index()
    {
        // Load articles, ordered by newest
        $articles = ClimateArticle::latest()->take(5)->get();

        // Load active campaigns (where progress < goal, or goal is null)
        $campaigns = Campaign::orderByDesc('created_at')->get();

        // Load nearest or all recycling points
        $recyclingPoints = RecyclingPoint::all();

        $clubs = $this->environmentalClubs();

        return view('climate.index', compact('articles', 'campaigns', 'recyclingPoints', 'clubs'));
    }

    public function joinClub(Request $request, Club $club)
    {
        $user = auth()->user();

        // Prevent joining twice
        if (!$club->members()->where('user_id', $user->id)->exists()) {
            $club->members()->attach($user->id);
            
            // Gamification reward for joining a club!
            $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);
            $profile->increment('points', 25);

            return back()->with('success', 'You have successfully joined the club! +25 Points');
        }

        return back()->with('info', 'You are already a member of this club.');
    }
}
