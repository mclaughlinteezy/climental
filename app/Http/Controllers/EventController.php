<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $query = Event::withCount('registrations')
            ->where('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc');

        if ($category) {
            $query->where('category', $category);
        }

        $events = $query->get();

        return view('events.index', compact('events', 'category'));
    }

    public function show(Event $event)
    {
        $event->loadCount('registrations');
        $isRegistered = $event->attendees()->where('user_id', auth()->id())->exists();

        return view('events.show', compact('event', 'isRegistered'));
    }

    public function rsvp(Request $request, Event $event)
    {
        $user = auth()->user();

        // Prevent double booking
        if (!$event->attendees()->where('user_id', $user->id)->exists()) {
            $event->attendees()->attach($user->id);
            
            // Gamification reward based on the event's point reward
            if ($event->points_reward > 0) {
                $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);
                $profile->increment('points', $event->points_reward);
            }

            return back()->with('success', 'You have successfully RSVP\'d for this event! +' . $event->points_reward . ' Points');
        }

        // Allow user to cancel RSVP
        $event->attendees()->detach($user->id);
        
        // Remove points (optional, let's just detach to keep gamification positive)
        
        return back()->with('info', 'Your RSVP has been cancelled.');
    }
}
