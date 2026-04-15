<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportPost extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(SupportGroup::class, 'support_group_id');
    }

    public function comments()
    {
        return $this->hasMany(SupportComment::class);
    }

    public function likes()
    {
        return $this->hasMany(SupportPostLike::class);
    }

    public function repostSource()
    {
        return $this->belongsTo(self::class, 'repost_of_id');
    }

    public function reposts()
    {
        return $this->hasMany(self::class, 'repost_of_id');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
