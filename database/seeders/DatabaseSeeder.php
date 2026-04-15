<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\MentalHealthTip;
use App\Models\Organization;
use App\Models\Event;
use App\Models\Club;
use App\Models\ClimateArticle;
use App\Models\Campaign;
use App\Models\RecyclingPoint;
use App\Models\SupportGroup;
use App\Models\SupportPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admins & Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@climental.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        Profile::create(['user_id' => $admin->id, 'points' => 1000]);

        $moderator = User::create([
            'name' => 'Mod User',
            'email' => 'mod@climental.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
        ]);
        Profile::create(['user_id' => $moderator->id, 'points' => 500]);

        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@climental.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        Profile::create(['user_id' => $student->id, 'points' => 50]);

        // 2. Mental Health Tips
        MentalHealthTip::create(['content' => 'Deep breathing for 5 minutes can lower cortisol levels instantly. Try the 4-7-8 method.']);
        MentalHealthTip::create(['content' => 'Spending 20 minutes in a green space reduces stress significantly.']);
        MentalHealthTip::create(['content' => 'It is okay to say no to social events when you need a mental health day.']);
        MentalHealthTip::create(['content' => 'Staying hydrated helps maintain cognitive focus and improves your mood.']);

        // 3. Organizations / Resource Directory
        Organization::create([
            'name' => 'Campus Wellness Center',
            'type' => 'clinic',
            'phone' => '+263 39 2266611',
            'website' => 'https://gzu.ac.zw/wellness',
            'description' => 'Providing free counseling and primary care for all students.',
            'latitude' => -20.0988,
            'longitude' => 30.7305
        ]);
        Organization::create([
            'name' => 'Masvingo General Hospital',
            'type' => 'clinic',
            'phone' => '+263-39-2262100',
            'description' => 'Secondary care and specialized counseling services.',
            'latitude' => -20.0715,
            'longitude' => 30.8340
        ]);
        Organization::create([
            'name' => 'Natasha Youth Line Hub',
            'type' => 'crisis_line',
            'phone' => '0800 11 00 22',
            'description' => 'Local crisis response and psychological support.',
            'latitude' => -20.0750,
            'longitude' => 30.8300
        ]);

        // 4. Events
        Event::create([
            'title' => 'Mindfulness & Meditation Workshop',
            'description' => 'A guided session focused on stress management techniques during exams.',
            'category' => 'mental_health',
            'event_date' => now()->addDays(5)->format('Y-m-d H:i:s'),
            'location' => 'University Chapel Park',
            'points_reward' => 25
        ]);
        Event::create([
            'title' => 'Campus Clean-up & Recycling Drive',
            'description' => 'Join us as we clean the residential halls and sort waste for the new recycling hub.',
            'category' => 'climate',
            'event_date' => now()->addDays(10)->format('Y-m-d H:i:s'),
            'location' => 'Main Gate Plaza',
            'points_reward' => 50
        ]);

        // 5. Climate Articles
        ClimateArticle::create([
            'title' => 'Understanding the Drought in Southern Africa',
            'author' => 'Dr. Mutasa',
            'content' => 'Detailed analysis of climate patterns affecting local agriculture...',
            'reading_time' => 8
        ]);
        ClimateArticle::create([
            'title' => '5 Ways to Live Plastic-Free on Campus',
            'author' => 'Eco-Champions',
            'content' => 'Start with a reusable bottle and avoid single-use straws...',
            'reading_time' => 4
        ]);

        // 6. Campaigns
        Campaign::create([
            'title' => 'Tree Planting Challenge 2026',
            'description' => 'Aiming to plant 10,000 indigenous trees by the end of the year.',
            'goal_amount' => 10000,
            'current_amount' => 4200
        ]);

        // 7. Clubs
        Club::create([
            'name' => 'Nature Guardians',
            'description' => 'Passionate about reforestation and local biodiversity conservation.',
            'club_points' => 1250,
            'slug' => 'nature-guardians'
        ]);
        Club::create([
            'name' => 'Wellness Bloom',
            'description' => 'Advocating for mental health awareness and peer-to-peer counseling.',
            'club_points' => 800,
            'slug' => 'wellness-bloom'
        ]);

        // 8. Support Groups & Forums
        $examGroup = SupportGroup::create([
            'name' => 'Exam Prep Anxiety',
            'description' => 'Sharing tips to manage stress during the finals period.',
            'icon' => 'bi-pencil-square'
        ]);
        SupportPost::create([
            'support_group_id' => $examGroup->id,
            'user_id' => $student->id,
            'title' => 'How to sleep better before an exam?',
            'content' => 'I have an exam tomorrow and my heart is racing. Any advice?'
        ]);

        $climateGroup = SupportGroup::create([
            'name' => 'Climate Grief Support',
            'description' => 'A space to process feelings about the changing environment.',
            'icon' => 'bi-cloud-sun'
        ]);

        // 9. Recycling Points
        RecyclingPoint::create([
            'name' => 'GZU Innovation Hub Recycling Center',
            'location' => 'Main Campus, Masvingo',
            'type' => 'mixed',
            'latitude' => -20.0982,
            'longitude' => 30.7310
        ]);
        RecyclingPoint::create([
            'name' => 'Mucheke Community Waste Point',
            'location' => 'Mucheke, Masvingo',
            'type' => 'plastic',
            'latitude' => -20.0820,
            'longitude' => 30.8150
        ]);

        // 10. Places
        \App\Models\Place::create([
            'name' => 'GZU Main Campus Library',
            'category' => 'library',
            'latitude' => -20.0995,
            'longitude' => 30.7295,
            'description' => 'Great Zimbabwe University Main Library.'
        ]);
    }
}
