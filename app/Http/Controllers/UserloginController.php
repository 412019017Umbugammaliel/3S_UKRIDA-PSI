<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Event;
use App\Models\Category;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserloginController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('id', 'desc')->get();
        return view('userlogin.index', compact('events'));
    }

    public function history()
    {
        try {
            $user = auth()->user();

            // Mendapatkan data tes untuk setiap nomor tes
            $testNumbers = History::where('id_user', $user->id)->pluck('test_number')->unique();

            // Mengumpulkan data hasil tes untuk setiap nomor tes
            $histories = collect();
            foreach ($testNumbers as $testNumber) {
                $categoryPoints = Answer::select('id_category', 'test_number')
                    ->selectRaw('SUM(point) as final_point')
                    ->where('id_user', $user->id)
                    ->where('test_number', $testNumber)
                    ->groupBy('id_category', 'test_number')
                    ->get();

                $histories->push([
                    'test_number' => $testNumber,
                    'categoryPoints' => $categoryPoints,
                ]);
            }

            $categories = Category::all();

            // Check if category points are defined
            $categoryPointsDefined = $histories->flatten()->pluck('categoryPoints')->flatten()->isNotEmpty();

            return view('userlogin.history', compact('histories', 'categories', 'categoryPointsDefined'));
        } catch (\Exception $e) {
            return redirect()->route('tes')->with(['error_message' => $e->getMessage()]);
        }
    }

    public function details($test_number)
    {
        try {
            $user = auth()->user();
            // Mendapatkan detail hasil tes berdasarkan 'test_number'
            $history = History::where('test_number', $test_number)
                ->where('id_user', $user->id)
                ->first();

            if (!$history) {
                throw new \Exception('History not found.');
            }

            // Mendapatkan data hasil tes untuk nomor tes tertentu
            $categoryPoints = Answer::select('id_category', 'test_number', DB::raw('SUM(point) as final_point'))
                ->where('id_user', $user->id)
                ->where('test_number', $test_number)
                ->groupBy('id_category', 'test_number')
                ->get();

            // Meneruskan data ke tampilan
            return view('userlogin.history-details', [
                'history' => $history,
                'categoryPoints' => $categoryPoints,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('history')->with(['error_message' => $e->getMessage()]);
        }
    }

}
