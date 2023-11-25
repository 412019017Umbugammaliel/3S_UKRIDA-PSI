<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    public $timestamps = true;
    use HasFactory;

    protected $fillable = [
        'id_category',
        'title',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
