<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupportGroup extends Model {
    protected $guarded = [];
    public function posts() { return $this->hasMany(SupportPost::class); }
}