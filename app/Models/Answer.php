<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['id_question', 'id_user', 'point'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
