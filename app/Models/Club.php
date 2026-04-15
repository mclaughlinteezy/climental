<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Club extends Model {
    protected $guarded = [];
    public function members() { return $this->belongsToMany(User::class, "club_members"); }
}