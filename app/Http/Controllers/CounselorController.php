<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CounselorController extends Controller
{
    public function index()
    {
        $histories = DB::table('histories')
            // ->join('categories', 'histories.id_category', '=', 'categories.id_category')
            ->join('users', 'histories.id_user', '=', 'users.id')
            ->select('histories.*', 'users.id as id_user', 'users.name as username')
            ->orderBy('histories.id', 'desc')
            ->get();
        $categories = Category::all();
        $users = User::all();

        return view('counselorlogin.index', compact('histories', 'categories', 'users'));
    }
}
