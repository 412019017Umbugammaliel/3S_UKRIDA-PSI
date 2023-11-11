<?php

namespace App\Http\Controllers;


use App\Models\Content;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $content = Content::orderBy('id', 'desc')->get();

        return view('welcome', compact('content'));
    }
}
