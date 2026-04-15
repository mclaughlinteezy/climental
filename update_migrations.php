<?php

$migrations = [
    'roles' => '
            $table->id();
            $table->string("name")->unique();
            $table->string("description")->nullable();
            $table->timestamps();
    ',
    'profiles' => '
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->integer("points")->default(0);
            $table->integer("streak")->default(0);
            $table->string("bio")->nullable();
            $table->string("avatar")->nullable();
            $table->timestamps();
    ',
    'organizations' => '
            $table->id();
            $table->string("name");
            $table->string("type"); // clinic, crisis_line, etc.
            $table->string("phone")->nullable();
            $table->string("website")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();
    ',
    'mental_health_tips' => '
            $table->id();
            $table->text("content");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
    ',
    'mood_checkins' => '
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("emoji");
            $table->text("note")->nullable();
            $table->timestamps();
    ',
    'events' => '
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("category"); // mental_health, climate, mixed
            $table->dateTime("event_date");
            $table->string("location")->nullable();
            $table->integer("points_reward")->default(0);
            $table->timestamps();
    ',
    'event_registrations' => '
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("event_id")->constrained()->onDelete("cascade");
            $table->timestamps();
    ',
    'places' => '
            $table->id();
            $table->string("name");
            $table->string("category"); // clinic, eco_club, library
            $table->decimal("latitude", 10, 8);
            $table->decimal("longitude", 11, 8);
            $table->timestamps();
    ',
    'climate_articles' => '
            $table->id();
            $table->string("title");
            $table->text("content");
            $table->timestamps();
    ',
    'recycling_points' => '
            $table->id();
            $table->string("name");
            $table->string("accepted_materials");
            $table->decimal("latitude", 10, 8);
            $table->decimal("longitude", 11, 8);
            $table->timestamps();
    ',
    'campaigns' => '
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->integer("goal")->nullable();
            $table->integer("current_progress")->default(0);
            $table->timestamps();
    ',
    'support_groups' => '
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->timestamps();
    ',
    'support_posts' => '
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("support_group_id")->nullable()->constrained("support_groups")->onDelete("cascade");
            $table->text("content");
            $table->timestamps();
    ',
    'support_comments' => '
            $table->id();
            $table->foreignId("support_post_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->text("content");
            $table->timestamps();
    ',
    'clubs' => '
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->timestamps();
    ',
    'club_members' => '
            $table->id();
            $table->foreignId("club_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->timestamps();
    ',
    'feedback' => '
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->text("content");
            $table->timestamps();
    ',
    'reports' => '
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade"); // Reporter
            $table->string("reportable_type"); // model type
            $table->unsignedBigInteger("reportable_id");
            $table->text("reason");
            $table->timestamps();
    ',
];

$dir = __DIR__ . "/database/migrations";
$files = scandir($dir);
foreach ($files as $file) {
    if ($file === "." || $file === "..") continue;
    $path = $dir . "/" . $file;
    if (is_file($path)) {
        $content = file_get_contents($path);
        
        // Find which table this migration is for
        preg_match("/Schema::create\('([^']+)',/", $content, $matches);
        if (isset($matches[1])) {
            $table = $matches[1];
            if (isset($migrations[$table])) {
                $schema = $migrations[$table];
                $newContent = preg_replace(
                    "/Schema::create\('$table', function \(Blueprint \\\$table\) \{(.*?)\}\);/s",
                    "Schema::create('$table', function (Blueprint \$table) { $schema });",
                    $content
                );
                file_put_contents($path, $newContent);
                echo "Updated migration for $table\n";
            }
        }
    }
}
