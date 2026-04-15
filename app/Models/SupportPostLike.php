<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportPostLike extends Model
{
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(SupportPost::class, 'support_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
