<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewYorkTimes extends Model
{
    protected $table = 'new_york_times';

    protected $fillable = [
        'headline',
        'snippet',
        'web_url',
        'pub_date',
        'source',
        'keywords'
    ];
    
    protected $casts = [
        'pub_date' => 'datetime',
        'keywords' => 'array'
    ];
}
