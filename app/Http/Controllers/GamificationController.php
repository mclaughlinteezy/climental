<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class GamificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile()->firstOrCreate(['user_id' => $user->id], ['points' => 0, 'streak' => 0]);

        // Calculate badges dynamically based on specs:
        // Eco Champion: User is a member of at least 1 club or has points > 50
        // Wellness Streak: User has a streak >= 3
        
        $badges = [];
        
        $hasClubs = $user->clubs()->exists();
        if ($hasClubs || $profile->points >= 50) {
            $badges[] = [
                'name' => 'Eco Champion',
                'description' => 'Awarded for participating in climate action and clubs.',
                'icon' => 'bi-tree-fill',
                'color' => 'text-success',
                'bg' => 'bg-light-success',
                'theme' => 'eco',
                'label' => 'Impact badge',
            ];
        }

        if ($profile->streak >= 3) {
            $badges[] = [
                'name' => 'Wellness Streak',
                'description' => 'Awarded for checking in consistently for 3 or more days in a row.',
                'icon' => 'bi-heart-pulse-fill',
                'color' => 'text-danger',
                'bg' => 'bg-light-danger',
                'theme' => 'wellness',
                'label' => 'Consistency badge',
            ];
        }

        // Leaderboard: top 10 users with highest points
        $leaderboard = Profile::with('user')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();

        return view('gamification.index', compact('profile', 'badges', 'leaderboard'));
    }
}
