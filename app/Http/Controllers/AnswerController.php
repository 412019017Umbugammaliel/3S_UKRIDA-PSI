<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function getAllDataGroup()
    {
        $answers = DB::table('answers')
            ->join('categories', 'answers.id_category', '=', 'categories.id_category')
            ->join('users', 'answers.id_user', '=', 'users.id')
            ->select('answers.*', 'categories.name_category', 'users.id as id_user', 'users.name as username')
            ->orderBy('answers.id', 'desc')
            ->get();

        $categories = Category::all();
        $users = User::all();

        return view('pageanswer.index', compact('answers', 'categories', 'users'));
    }


    public function index()
    {
        return $this->getAllDataGroup();
    }

    public function create()
    {
        $categories = $this->getCategories();
        $users = $this->getUsers();

        return view('pageanswer.answer_modal', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|exists:categories,id_category',
            'id_user' => 'required|exists:users,id',
            'point' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Answer::create([
            'id_category' => $request->id_category,
            'id_user' => $request->id_user,
            'point' => $request->point,
        ]);

        return redirect()->route('pageanswer')->with('success', 'Berhasil menambahkan Jawaban!');
    }


    public function show($answer)
    {
        return view('pageanswer.index', ['answer' => $answer]);
    }

    public function edit($id)
    {
        $answer = Answer::findOrFail($id);
        $categories = Category::all();
        $users = User::all();

        return view('pageanswer.answer_modal', ['editMode' => true, 'answer' => $answer, 'categories' => $categories, 'users' => $users]);
    }



    public function update(Request $request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|exists:categories,id_category',
            'id_user' => 'required|exists:users,id',
            'point' => 'required|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Find the answer based on the provided id
            $answer = Answer::findOrFail($id);

            // Check if the answer is found
            if (!$answer) {
                return redirect()->route('pageanswer')->withError('Answer not found');
            }

            // Update the answer attributes
            $answer->id_category = $request->id_category;
            $answer->id_user = $request->id_user;
            $answer->point = $request->point;

            // Save the updated answer
            $answer->save();

            return redirect()->route('pageanswer')->withSuccess('Jawaban Berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('pageanswer')->withError('Terjadi Error ketika update Answer: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return redirect()->route('pageanswer')->withError('Answer not found');
        }

        // Perform the deletion action
        $answer->delete();

        return redirect()->route('pageanswer')->withSuccess(' Data Jawaban Berhasil dihapus');
    }
}
