<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CounselorController extends Controller
{
    public function index()
    {
        // Get all categories and users
        $categories = Category::all();
        $users = User::all();

        // Get unique test numbers for all users
        $testNumbers = History::pluck('test_number')->unique();

        // Collect data for each test number and associate it with the user
        $histories = collect();
        foreach ($testNumbers as $testNumber) {
            $userHistories = History::where('test_number', $testNumber)->get();

            foreach ($userHistories as $userHistory) {
                $categoryPoints = Answer::select('id_category', 'test_number')
                    ->selectRaw('SUM(point) as final_point')
                    ->where('test_number', $testNumber)
                    ->where('id_user', $userHistory->id_user)
                    ->groupBy('id_category', 'test_number')
                    ->get();

                $histories->push([
                    'id' => $userHistory->id, // tambah id disini
                    'test_number' => $testNumber,
                    'user_id' => $userHistory->id_user,
                    'username' => $userHistory->user->name ?? 'N/A',
                    'categoryPoints' => $categoryPoints,
                ]);
            }
        }

        $categoryPointsDefined = $histories->flatten()->pluck('categoryPoints')->flatten()->isNotEmpty();

        return view('counselorlogin.index', compact('histories', 'categories', 'users', 'categoryPointsDefined'));
    }

    public function details($historyId)
    {
        try {
            // Mendapatkan detail hasil tes berdasarkan ID
            $history = History::findOrFail($historyId);

            // Mendapatkan data hasil tes untuk nomor tes tertentu dan ID pengguna tertentu
            $categoryPoints = Answer::select('id_category', 'test_number', DB::raw('SUM(point) as final_point'))
                ->where('id_user', $history->id_user)
                ->where('test_number', $history->test_number)
                ->groupBy('id_category', 'test_number')
                ->get();

            // Meneruskan data ke tampilan
            return view('counselorlogin.details', [
                'history' => $history,
                'categoryPoints' => $categoryPoints,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('counselorlogin.index')->with(['error_message' => $e->getMessage()]);
        }
    }

}