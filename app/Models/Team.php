<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'postion',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
        'instagram_url',
        'status',

    ];
}
