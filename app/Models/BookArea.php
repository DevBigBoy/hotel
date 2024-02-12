<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'short_title',
        'description',
        'link',
        'status',
    ];
}
