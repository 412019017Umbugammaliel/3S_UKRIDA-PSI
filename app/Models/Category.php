<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_category',
        'image_category',
    ];

    protected $table = 'categories';
    protected $primaryKey = 'id_category';

    public function questions()
    {
        return $this->hasMany(Question::class, 'id_category');
    }
}
