<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class TesController extends Controller
{
    public function index($currentQuestionIndex = 0, $currentQuestion = null)
    {
        $questionsWithAnswers = $currentQuestion
            ? Question::with('answers')->orderBy('id_category')->get()
            : Question::with('answers')->orderBy('id_category')->get();

        $currentQuestion = $currentQuestion
            ? Question::with('answers')->find($currentQuestion)
            : $questionsWithAnswers->first();

        if ($currentQuestion) {
            $answers = $currentQuestion->answers;

            return view('userlogin.tes', [
                'currentQuestionIndex' => $currentQuestionIndex,
                'currentQuestion' => $currentQuestion,
                'answers' => $answers,
                'questionsWithAnswers' => $questionsWithAnswers,
            ]);
        }
    }

    public function processAnswer(Request $request)
    {
        $idQuestion = $request->input('id_question');
        $selectedAnswerIndex = $request->input('selected_answer') - 1;

        $currentQuestion = Question::find($idQuestion);


        $selectedAnswer = $currentQuestion->answers[$selectedAnswerIndex] ?? null;

        if ($selectedAnswer) {
            $points = $selectedAnswer->point;

            $user = auth()->user();
            $user->answers()->create([
                'id_question' => $idQuestion,
                'point' => $points,
            ]);
        }

        $nextQuestionIndex = $request->input('action') === 'next' ? $request->input('currentQuestionIndex') + 1 : $request->input('currentQuestionIndex') - 1;

        return redirect()->route('tes', [
            'currentQuestionIndex' => $nextQuestionIndex,
            'currentQuestion' => null,
        ]);
    }

}
