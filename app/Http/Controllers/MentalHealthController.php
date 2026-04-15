<?php

namespace App\Http\Controllers;

use App\Models\MentalHealthTip;
use App\Models\MoodCheckin;
use App\Models\Organization;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class MentalHealthController extends Controller
{
    private function wellnessClubCatalog(): array
    {
        return [
            [
                'name' => 'Wellness Bloom',
                'slug' => 'wellness-bloom',
                'description' => 'Sports, movies, edutainment sessions, trips, and social activities that help students relax, connect, and recharge.',
                'club_points' => 800,
                'activities' => 'Sports, movies, edutainment, trips',
            ],
            [
                'name' => 'Support Groups',
                'slug' => 'support-groups',
                'description' => 'Monthly talks, guided discussions, and outreach activities that create safe spaces for students to share and feel heard.',
                'club_points' => 700,
                'activities' => 'Monthly talks, discussions, outreach',
            ],
            [
                'name' => 'Mental Health Ambassadors',
                'slug' => 'mental-health-ambassadors',
                'description' => 'Student leaders who take part in trainings, awareness outreach, and wellbeing activities across campus.',
                'club_points' => 950,
                'activities' => 'Trainings, outreach, activities',
            ],
        ];
    }

    private function wellnessClubs(): Collection
    {
        foreach ($this->wellnessClubCatalog() as $club) {
            Club::updateOrCreate(
                ['slug' => $club['slug']],
                [
                    'name' => $club['name'],
                    'description' => $club['description'],
                    'club_points' => $club['club_points'],
                ]
            );
        }

        $activityMap = collect($this->wellnessClubCatalog())->keyBy('slug');

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

    private function moodTipForEmoji(?string $emoji): array
    {
        return match ($emoji) {
            '😄' => [
                'emoji' => '😄',
                'title' => 'Daily tip for a happy mood',
                'tip' => 'Take a moment to notice what is going well today. Positive moments become stronger when you name them and share them.',
            ],
            '🙂' => [
                'emoji' => '🙂',
                'title' => 'Daily tip for a calm mood',
                'tip' => 'Protect this steady feeling with one gentle habit today, like a short walk, water, rest, or a few deep breaths.',
            ],
            '😢' => [
                'emoji' => '😢',
                'title' => 'Daily tip for a sad mood',
                'tip' => 'Be kind to yourself today. Try one small act of care, and if the weight feels heavy, reach out to someone safe.',
            ],
            '😨' => [
                'emoji' => '😨',
                'title' => 'Daily tip for a scared mood',
                'tip' => 'Slow your breathing and name what feels scary. Breaking fear into one next step can help it feel less overwhelming.',
            ],
            '😫' => [
                'emoji' => '😫',
                'title' => 'Daily tip for an overwhelmed mood',
                'tip' => 'Pause and choose only one task to focus on first. You do not have to solve everything at once.',
            ],
            default => [
                'emoji' => '🙂',
                'title' => 'Daily tip',
                'tip' => 'Check in gently with yourself today and ask what kind of support, rest, or encouragement you need most.',
            ],
        };
    }

    public function index()
    {
        $organizations = Organization::all()->groupBy('type');

        $dailyTip = MentalHealthTip::where('is_active', true)->inRandomOrder()->first();

        $moodHistory = MoodCheckin::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        $checkedInToday = MoodCheckin::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->exists();

        $moodGuidance = [
            [
                'key' => 'happy',
                'emoji' => '😄',
                'button_style' => 'success',
                'title' => 'You are carrying good energy today',
                'message' => 'Hold onto this moment. Joy can steady you, brighten someone else\'s day, and give you energy to keep showing up for yourself.',
                'prompt' => 'What is making you feel happy right now, and how can you protect more moments like this?',
                'support_title' => 'Keep the momentum going',
                'support_text' => 'You could share encouragement in a support group or explore a climate action activity that keeps your sense of purpose strong.',
            ],
            [
                'key' => 'calm',
                'emoji' => '🙂',
                'button_style' => 'secondary',
                'title' => 'A steady mood is worth noticing',
                'message' => 'Feeling okay is still meaningful. Calm days can be a chance to rest, reset, and check in with what your mind and body need.',
                'prompt' => 'Is there one small thing you can do today to protect your peace?',
                'support_title' => 'Gentle support is still support',
                'support_text' => 'If you want connection, you can browse wellbeing services or join a peer group before stress builds up.',
            ],
            [
                'key' => 'sad',
                'emoji' => '😢',
                'button_style' => 'primary',
                'title' => 'It is okay to need softness today',
                'message' => 'Hard feelings do not make you weak. You deserve care, rest, and someone who will listen without judging you.',
                'prompt' => 'Would it help to talk about what is weighing on you right now?',
                'support_title' => 'You do not have to carry this alone',
                'support_text' => 'Counselling, campus clinics, and peer support spaces are available if you want someone to talk to.',
            ],
            [
                'key' => 'scared',
                'emoji' => '😨',
                'button_style' => 'warning',
                'title' => 'Fear often points to something that matters',
                'message' => 'When you feel scared, your body may be trying to protect you. Slowing down and naming the fear can make it feel more manageable.',
                'prompt' => 'What feels scary right now, and do you want support figuring out your next safe step?',
                'support_title' => 'Support can help you feel safer',
                'support_text' => 'If the fear feels intense or urgent, reach out to crisis support or emergency services right away.',
            ],
            [
                'key' => 'overwhelmed',
                'emoji' => '😫',
                'button_style' => 'danger',
                'title' => 'You have been carrying a lot',
                'message' => 'Overwhelm is a sign that your mind may need a pause, not proof that you are failing. One small step is enough for now.',
                'prompt' => 'What is the one thing causing the most pressure today?',
                'support_title' => 'Let someone help lighten the load',
                'support_text' => 'A counsellor, trusted support service, or peer group can help you sort through what feels too heavy.',
            ],
        ];

        $didYouKnowFacts = [
            [
                'title' => 'Climate stress is real',
                'content' => 'Heat, droughts, floods, and uncertainty about the future can increase stress, anxiety, and feelings of helplessness, especially for young people.',
            ],
            [
                'title' => 'Nature can support wellbeing',
                'content' => 'Time in green spaces, fresh air, and gentle movement outdoors can help reduce stress and improve mood for many people.',
            ],
            [
                'title' => 'Community builds resilience',
                'content' => 'Talking with others, joining local action, and feeling part of a response can reduce isolation and help people cope with climate-related worry.',
            ],
        ];

        $wellnessClubs = $this->wellnessClubs();

        return view('mental-health.index', compact(
            'organizations',
            'dailyTip',
            'moodHistory',
            'checkedInToday',
            'moodGuidance',
            'didYouKnowFacts',
            'wellnessClubs',
        ));
    }

    public function storeMood(Request $request)
    {
        $request->validate([
            'emoji' => 'nullable|string|max:10',
            'mood_score' => 'nullable|integer|min:1|max:5',
            'note' => 'nullable|string|max:500',
        ]);

        $emoji = $request->emoji;

        if (!$emoji && $request->mood_score) {
            $map = [
                1 => '😫',
                2 => '😨',
                3 => '🙂',
                4 => '😄',
                5 => '🤩',
            ];

            $emoji = $map[$request->mood_score] ?? '🙂';
        }

        MoodCheckin::create([
            'user_id' => auth()->id(),
            'emoji' => $emoji,
            'note' => $request->note,
        ]);

        $profile = auth()->user()->profile()->firstOrCreate(['user_id' => auth()->id()]);
        $profile->increment('points', 10);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Wellness check-in recorded! You earned 10 points.')
            ->with('mood_tip', $this->moodTipForEmoji($emoji));
    }

    public function emergency()
    {
        $clinics = Organization::where('type', 'clinic')
            ->orWhere('type', 'crisis_line')
            ->get();

        return view('mental-health.emergency', compact('clinics'));
    }

    public function joinClub(Request $request, Club $club)
    {
        $user = auth()->user();

        if (!$club->members()->where('user_id', $user->id)->exists()) {
            $club->members()->attach($user->id);

            $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);
            $profile->increment('points', 25);

            return back()->with('success', 'You have successfully joined the wellness club! +25 Points');
        }

        return back()->with('info', 'You are already a member of this club.');
    }
}
