<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'published_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
