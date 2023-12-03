<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesController extends Controller
{
    public function index($currentQuestionIndex = 0, $currentQuestionId = null)
    {
        try {
            $categories = Category::all();

            $questionsWithAnswers = Question::with('category')
                ->orderBy('id_category')
                ->orderBy('id_question')
                ->get();

            $currentQuestion = $currentQuestionId
                ? $questionsWithAnswers->where('id_question', $currentQuestionId)->first()
                : $questionsWithAnswers->first();

            if (!$currentQuestion) {
                throw new \Exception('Current question not found.');
            }

            if (!$currentQuestion->category) {
                throw new \Exception('Current question category not found.');
            }

            $user = auth()->user();

            $currentQuestionCategoryID = $currentQuestion->id_category;

            $currentCategoryAnswers = range(1, 6);

            $categoryPoints = Answer::select('id_category', DB::raw('SUM(point) as total_points'))
                ->where('id_user', $user->id)
                ->groupBy('id_category')
                ->get();

            return view('userlogin.tes', [
                'currentQuestionIndex' => $currentQuestionIndex,
                'currentQuestion' => $currentQuestion,
                'questionsWithAnswers' => $questionsWithAnswers,
                'categories' => $categories,
                'categoryPoints' => $categoryPoints,
                'currentCategoryAnswers' => $currentCategoryAnswers,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('tes')->with(['question_not_found' => $e->getMessage()]);
        }
    }

    public function processAnswer(Request $request)
    {
        $categoryData = json_decode($request->input('category_data'), true);
        // var_dump($categoryData);
        // die;
        $jumlahArray = [];

        foreach ($categoryData as $categoryId => $data) {
            $array = array_map('intval', $data['answers']);

            $jumlah = [
                'jumlah'   => array_sum($array),
                'kategori' => $data['idCategory'],
            ];

            $jumlahArray[] = $jumlah;
        }


        // $request->validate([
        //     'selected_answer' => 'required|in:1,2,3,4,5,6',
        //     'id_category' => 'required',
        //     // 'id_question' => 'required',
        //     'currentQuestionIndex' => 'required',
        //     'id_user' => 'required',
        // ]);

        $userId = auth()->user()->id;
        $questionId = $request->input('id_question');
        //


        $categoryId = $request->input('id_category');
        $selectedAnswer = $request->input('selected_answer');
        $answers  = Answer::where('id_user', $userId)->get();

        if ($answers->isNotEmpty()) {
            // Records exist, update each one
            foreach ($answers as $index => $answer) {
                $dat = $jumlahArray[$index] ?? null; // Retrieve corresponding data from $jumlahArray

                if ($dat) {
                    $answer->update([
                        'point' => $dat['jumlah'],
                        'id_category' => $dat['kategori'],
                        // Add other columns to update if needed
                    ]);
                }
            }
        } else {
            // Records do not exist, create new records
            foreach ($jumlahArray as $dat) {
                Answer::create([
                    'id_user' => $userId,
                    'id_category' => $dat['kategori'],
                    // 'id_question' => $questionId,
                    'point' => $dat['jumlah'],
                ]);
            }
        }

        // dd("succes");
        // Perbarui poin pada tabel histories
        $categoryPoints = Answer::select('id_user', DB::raw('SUM(point) as total_points'))
            ->where('id_user', $userId)
            ->groupBy('id_user')
            ->get();

        foreach ($categoryPoints as $categoryPoint) {

            History::updateOrCreate(
                [
                    'id_user' => $userId,
                    // 'id_category' => $categoryPoint->id_category,
                ],
                [
                    'final_point' => $categoryPoint->total_points,
                ]
            );
        }

        // var_dump($questionId);
        // die;
        // Redirect ke halaman tes berikutnya atau ke halaman hasil
        // $nextQuestionIndex = $request->input('currentQuestionIndex')[0] + 1;
        // $nextQuestionId = $questionId[0] + 1; // Assuming questions have consecutive IDs

        // $lastQuestionId = Question::max('id_question');
        // if ($nextQuestionId > $lastQuestionId) {
        //     // Jika ini adalah pertanyaan terakhir, redirect ke halaman hasil
        //     return redirect()->route('tes', [
        //         'currentQuestionIndex' => $nextQuestionIndex,
        //         'currentQuestionId' => $nextQuestionId,
        //     ]);
        // } else {
        // Jika masih ada pertanyaan berikutnya, redirect ke halaman tes
        return redirect()->route('results');
        // }
    }

    public function results()
    {
        $user = auth()->user();

        $categories = Category::all();

        // Mengambil data hasil tes dari tabel 'history'
        $categoryPoints = Answer::select('id_category', DB::raw('SUM(point) as total_points'))
            ->where('id_user', $user->id)
            ->groupBy('id_category')
            ->get();
        // var_dump($categoryPoints);
        // die;
        return view('userlogin.results', [
            'categories' => $categories,
            'categoryPoints' => $categoryPoints,
        ]);
    }
}
