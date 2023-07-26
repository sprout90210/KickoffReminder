<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'crest',
        'venue',
        'website',
        'twitter',
        'youtube',
        'insatgram',
    ];
    
}
