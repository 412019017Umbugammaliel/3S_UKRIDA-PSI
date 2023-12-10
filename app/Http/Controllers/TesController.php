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

            // $currentQuestionCategoryID = $currentQuestion->id_category;

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
        try {
            $categoryData = json_decode($request->input('category_data'), true);

            $jumlahArray = [];

            foreach ($categoryData as $data) {
                $array = array_map('intval', $data['answers']);

                $jumlah = [
                    'jumlah' => array_sum($array),
                    'kategori' => $data['idCategory'],
                ];

                $jumlahArray[] = $jumlah;
            }

            $userId = auth()->user()->id;

            // Mendapatkan nomor tes yang terakhir dilakukan
            $latestTestNumber = History::where('id_user', $userId)->max('test_number') + 1;

            // Create new records for the newly submitted answers
            foreach ($jumlahArray as $dat) {
                Answer::create([
                    'id_user' => $userId,
                    'id_category' => $dat['kategori'],
                    'point' => $dat['jumlah'],
                    'test_number' => $latestTestNumber,
                ]);
            }

            // Create a new history record for the current test
            $totalPoints = array_sum(array_column($jumlahArray, 'jumlah'));
            History::create([
                'id_user' => $userId,
                'final_point' => $totalPoints,
                'test_number' => $latestTestNumber,
            ]);

            return redirect()->route('results');
        } catch (\Exception $e) {
            return redirect()->route('tes')->with(['error_message' => $e->getMessage()]);
        }
    }

    public function results()
    {
        try {
            $user = auth()->user();
            $categories = Category::all();

            // Mendapatkan data hasil tes terakhir untuk setiap kategori
            $latestCategoryPoints = Answer::select('id_category', 'test_number', DB::raw('SUM(point) as final_point'))
                ->where('id_user', $user->id)
                ->groupBy('id_category', 'test_number')
                ->latest('test_number') // Mengambil hasil tes terakhir
                ->get();

            return view('userlogin.results', [
                'categories' => $categories,
                'latestCategoryPoints' => $latestCategoryPoints,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('tes')->with(['error_message' => $e->getMessage()]);
        }
    }

}
