<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = DB::table('questions')
            ->join('categories', 'questions.id_category', '=', 'categories.id_category')
            ->orderBy('questions.id_question', 'desc')
            ->select('questions.*', 'categories.name_category')
            ->get();

        $categories = Category::all();

        return view('pagequestion.index', compact('questions', 'categories'));
    }

    private function getCategories()
    {
        return Category::all();
    }

    public function create()
    {
        $categories = $this->getCategories();
        return view('pagequestion.question_modal', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_category' => 'required',
            'questions' => 'required',
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = Category::findOrFail($request->id_category);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['id_category' => 'Kategori tidak valid'])->withInput();
        }

        $question = new Question;
        $question->questions = $request->questions;
        $question->title = $request->title;

        $question->category()->associate($category);

        $question->save();

        return redirect()->route('pagequestion')->withSuccess('Berhasil Menambahkan Pertanyaan Baru!');
    }

    public function show($id_question)
    {
        $question = Question::findOrFail($id_question);

        return view('pagequestion.index', compact('question'));
    }

    public function edit($id_question)
    {
        $question = Question::findOrFail($id_question);
        $categories = $this->getCategories();

        return view('pagequestion.question_modal', [
            'editMode' => true,
            'question' => $question,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id_question)
    {
        $validator = Validator::make($request->all(), [
            'id_category' => 'required',
            'questions' => 'required',
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = Category::findOrFail($request->id_category);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['id_category' => 'Kategori tidak valid'])->withInput();
        }

        $question = Question::findOrFail($id_question);
        $question->questions = $request->questions;
        $question->title = $request->title;

        $question->category()->associate($category);

        $question->save();

        return redirect()->route('pagequestion')->withSuccess('Pertanyaan berhasil diperbarui!');
    }


    public function destroy($id_question)
    {
        $question = Question::find($id_question);

        if (!$question) {
            return redirect()->route('pagequestion')->withError('Pertanyaan tidak ditemukan');
        }

        // Lakukan tindakan penghapusan di sini
        $question->delete();

        return redirect()->route('pagequestion')->withSuccess('Pertanyaan berhasil dihapus');
    }

}
