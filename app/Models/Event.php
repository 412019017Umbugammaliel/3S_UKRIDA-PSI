<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_date',
        'session_type',
        'availability',
        'image_path',
        'description',
    ];

    protected $table = 'events';
}
