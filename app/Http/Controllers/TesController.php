<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Category;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesController extends Controller
{
    public function index($currentQuestionIndex = 0, $currentQuestionId = null)
    {
        try {
            $categories = Question::distinct('id_category')->pluck('id_category');

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


            $currentCategoryAnswers = DB::table('answers')
                ->select('point')
                ->where('id_user', $user->id)
                ->where('id_category', $currentQuestionCategoryID)
                ->orderBy('point', 'desc')
                ->pluck('point')
                ->toArray();


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
        // Validate the form data
        $request->validate([
            'selected_answer' => 'required',
            'id_category' => 'required',
            'id_question' => 'required',
            'currentQuestionIndex' => 'required',
            'id_user' => 'required',
        ]);

        // Retrieve data from the form submission
        $userId = auth()->user()->id;
        $categoryId = $request->input('id_category');
        $questionId = $request->input('id_question');
        $selectedAnswer = $request->input('selected_answer');

        // Save the user's answer to the database
        Answer::create([
            'id_category' => $categoryId,
            'id_user' => $userId,
            'id_question' => $questionId,
            'point' => $selectedAnswer,
        ]);

        // Update or create entry in the 'histories' table
        History::updateOrCreate(
            [
                'id_user' => $userId,
                'id_category' => $categoryId,
            ],
            [
                'final_point' => DB::table('answers')
                    ->where('id_user', $userId)
                    ->where('id_category', $categoryId)
                    ->sum('point'),
            ]
        );

        // Redirect to the next question or a thank you page
        // You can customize this logic based on your requirements
        $nextQuestionIndex = $request->input('currentQuestionIndex') + 1;
        $nextQuestionId = $request->input('id_question') + 1; // Assuming questions have consecutive IDs

        return redirect()->route('tes', [
            'currentQuestionIndex' => $nextQuestionIndex,
            'currentQuestionId' => $nextQuestionId,
        ]);
    }

    public function results()
    {
        // Retrieve unique categories for available questions
        $categories = Question::distinct('id_category')->pluck('id_category');

        // Calculate total points per category for the current user
        $user = auth()->user();
        $categoryPoints = Answer::select('id_category', DB::raw('SUM(point) as total_points'))
            ->where('id_user', $user->id)
            ->groupBy('id_category')
            ->get();

        return view('userlogin.results', [
            'categories' => $categories,
            'categoryPoints' => $categoryPoints,
        ]);
    }
}
