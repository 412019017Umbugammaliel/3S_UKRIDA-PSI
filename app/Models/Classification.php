<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    public $timestamps = true;
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_category',
        'score',
        'conclusion'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }


}
