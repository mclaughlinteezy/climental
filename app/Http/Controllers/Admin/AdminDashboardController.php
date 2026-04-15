<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Organization;
use App\Models\MoodCheckin;
use App\Models\Report;
use App\Models\SupportPost;
use App\Models\Campaign;
use App\Models\Club;
use App\Models\Place;
use App\Models\RecyclingPoint;
use App\Models\SystemSetting;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'         => User::count(),
            'total_events'        => Event::count(),
            'total_organizations' => Organization::count(),
            'total_campaigns'     => Campaign::count(),
            'total_clubs'         => Club::count(),
            'total_reports'       => Report::count(),
            'total_posts'         => SupportPost::count(),
            'checkins_today'      => MoodCheckin::whereDate('created_at', Carbon::today())->count(),
            'total_places'        => Place::count(),
            'total_recycling_points' => RecyclingPoint::count(),
            'total_settings'      => SystemSetting::count(),
        ];

        // Recent users
        $recentUsers = User::latest()->take(5)->get();

        // Upcoming events
        $upcomingEvents = Event::where('event_date', '>=', Carbon::today())
            ->orderBy('event_date')
            ->take(5)
            ->withCount('registrations')
            ->get();

        // Pending reports
        $pendingReports = Report::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'upcomingEvents', 'pendingReports'));
    }
}
