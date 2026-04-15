<?php namespace App\Models;
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
    public function supportPostLikes() { return $this->hasMany(SupportPostLike::class); }
    public function clubs() { return $this->belongsToMany(Club::class, "club_members"); }
    public function feedbacks() { return $this->hasMany(Feedback::class); }
    public function reports() { return $this->hasMany(Report::class); }
}
