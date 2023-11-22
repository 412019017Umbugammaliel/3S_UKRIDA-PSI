<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_question';
    protected $table = 'questions';

    protected $fillable = [
        'id_category',
        'questions',
        'title',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
