<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Point;
use Illuminate\Http\Request;

class TesController extends Controller
{
    public function index($currentQuestionIndex = 0, $currentQuestion = null)
    {
        // Retrieve unique categories for available questions
        $categories = Question::distinct('id_category')->pluck('id_category');

        // $questions = Question::all();
        // dd($questions);
        // Check if the session has a current category
        $currentCategory = session('current_category', $categories->first());
        $point = Point::all();
        $questionsWithAnswers = Question::with('category')
            ->where('id_category', $currentCategory)
            ->orderBy('id_category')
            ->orderBy('id_question') // Replace 'id' with the correct column name
            ->get();


        $currentQuestion = $currentQuestion
            ? Question::with('category')->find($currentQuestion)
            : $questionsWithAnswers->first();

        if ($currentQuestion) {
            // $answers = $currentQuestion->answers;

            return view('userlogin.tes', [
                'currentQuestionIndex' => $currentQuestionIndex,
                'currentQuestion' => $currentQuestion,
                'point' => $point,
                'questionsWithAnswers' => $questionsWithAnswers,
                'categories' => $categories,
                'currentCategory' => $currentCategory,
            ]);
        }
    }


    public function processAnswer(Request $request)
    {
        $idQuestion = $request->input('id_question');
        $selectedAnswerIndex = $request->input('selected_answer') - 1;

        $currentQuestion = Question::find($idQuestion);

        if (!$currentQuestion instanceof Question) {
            return redirect()->route('tes')->with(['question_not_found' => 'Question not found. Please try again.']);
        }

        $selectedAnswer = $currentQuestion->answers[$selectedAnswerIndex] ?? null;

        if ($selectedAnswer) {
            $points = $selectedAnswer->point;

            $user = auth()->user();
            $user->answers()->create([
                'id_question' => $idQuestion,
                'point' => $points,
            ]);
        }

        // Check if there are more questions in the current category
        $hasMoreQuestionsInCategory = Question::where('id_category', $currentQuestion->id_category)
            ->where('id', '>', $idQuestion)
            ->exists();

        // If no more questions in the current category, move to the next category
        if (!$hasMoreQuestionsInCategory) {
            $categories = Question::distinct('id_category')->pluck('id_category');

            $currentCategoryIndex = array_search($currentQuestion->id_category, $categories->toArray());
            $nextCategoryIndex = $currentCategoryIndex + 1;

            // If it's the last category, reset to the first category
            if ($nextCategoryIndex >= count($categories)) {
                $nextCategoryIndex = 0;
            }

            $nextCategory = $categories[$nextCategoryIndex];

            // Store the next category in the session
            session(['current_category' => $nextCategory]);
        }

        $nextQuestionIndex = $request->input('action') === 'next' ? $request->input('currentQuestionIndex') + 1 : $request->input('currentQuestionIndex') - 1;

        return redirect()->route('tes', [
            'currentQuestionIndex' => $nextQuestionIndex,
            'currentQuestion' => null,
        ]);
    }
}
