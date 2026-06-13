<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'name',
        'whatsapp',
        'subject',
        'message'
    ];
}
