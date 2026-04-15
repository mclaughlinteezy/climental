<?php

$modelsDir = __DIR__.'/app/Models';

$models = [
    'User.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ["name", "email", "password", "role"];
    protected $hidden = ["password", "remember_token"];
    protected function casts(): array { return ["email_verified_at" => "datetime", "password" => "hashed"]; }
    public function profile() { return $this->hasOne(Profile::class); }
    public function moodCheckins() { return $this->hasMany(MoodCheckin::class); }
    public function eventRegistrations() { return $this->hasMany(EventRegistration::class); }
    public function supportPosts() { return $this->hasMany(SupportPost::class); }
    public function supportComments() { return $this->hasMany(SupportComment::class); }
    public function clubs() { return $this->belongsToMany(Club::class, "club_members"); }
    public function feedbacks() { return $this->hasMany(Feedback::class); }
    public function reports() { return $this->hasMany(Report::class); }
}',
    'Role.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends Model { protected $guarded = []; }',
    'Profile.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Profile extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
}',
    'Organization.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Organization extends Model { protected $guarded = []; }',
    'MentalHealthTip.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MentalHealthTip extends Model { protected $guarded = []; }',
    'MoodCheckin.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MoodCheckin extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
}',
    'Event.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Event extends Model {
    protected $guarded = [];
    public function registrations() { return $this->hasMany(EventRegistration::class); }
    public function attendees() { return $this->belongsToMany(User::class, "event_registrations"); }
}',
    'EventRegistration.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EventRegistration extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function event() { return $this->belongsTo(Event::class); }
}',
    'Place.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Place extends Model { protected $guarded = []; }',
    'ClimateArticle.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ClimateArticle extends Model { protected $guarded = []; }',
    'RecyclingPoint.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RecyclingPoint extends Model { protected $guarded = []; }',
    'Campaign.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Campaign extends Model { protected $guarded = []; }',
    'SupportGroup.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupportGroup extends Model {
    protected $guarded = [];
    public function posts() { return $this->hasMany(SupportPost::class); }
}',
    'SupportPost.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupportPost extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function group() { return $this->belongsTo(SupportGroup::class, "support_group_id"); }
    public function comments() { return $this->hasMany(SupportComment::class); }
}',
    'SupportComment.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupportComment extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function post() { return $this->belongsTo(SupportPost::class, "support_post_id"); }
}',
    'Club.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Club extends Model {
    protected $guarded = [];
    public function members() { return $this->belongsToMany(User::class, "club_members"); }
}',
    'ClubMember.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ClubMember extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function club() { return $this->belongsTo(Club::class); }
}',
    'Feedback.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Feedback extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
}',
    'Report.php' => '<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Report extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function reportable() { return $this->morphTo(); }
}'
];

foreach ($models as $file => $content) {
    file_put_contents($modelsDir . '/' . $file, $content);
    echo "Updated $file\n";
}
