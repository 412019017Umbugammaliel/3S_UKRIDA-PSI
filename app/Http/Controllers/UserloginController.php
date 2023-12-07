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
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Mendapatkan riwayat (history) yang terkait dengan pengguna yang sedang login
        $histories = DB::table('histories')
            ->join('users', 'histories.id_user', '=', 'users.id')
            ->where('histories.id_user', $user->id)
            ->select('histories.*', 'users.name as username')
            ->orderBy('histories.id', 'desc')
            ->get();

        $categories = Category::all();

        return view('userlogin.history', compact('histories', 'categories'));
    }

    public function details($historyId)
    {
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Mendapatkan data hasil tes dari tabel 'history' berdasarkan ID tertentu
        $history = History::where('id', $historyId)
            ->where('id_user', $user->id)
            ->first();

        // Check if history exists
        if (!$history) {
            return redirect()->route('history')->withError('Riwayat tidak ditemukan');
        }

        // Mengambil data hasil tes untuk setiap kategori dari tabel 'answers'
        $categoryPoints = Answer::select('id_category', DB::raw('SUM(point) as total_points'))
            ->where('id_user', $user->id)
            ->groupBy('id_category')
            ->get();

        // Check if categoryPoints exist
        if ($categoryPoints->isEmpty()) {
            return redirect()->route('history')->withError('Tidak ada data points untuk kategori');
        }

        // Mengambil kategori dan klasifikasi
        $categories = Category::all();
        $classifications = [];

        // Check if categories exist
        if ($categories->isEmpty()) {
            return redirect()->route('history')->withError('Tidak ada data kategori');
        }

        // Ambil klasifikasi berdasarkan kategori
        foreach ($categories as $category) {
            $classifications[$category->id_category] = $category->classifications;
        }

        // Debugging 
        // dd($history, $categories, $classifications, $categoryPoints);

        return view('userlogin.history', compact('history', 'categories', 'classifications', 'categoryPoints'));
    }


    // public function destroy($id)
    // {
    //     $history = History::find($id);

    //     if (!$history) {
    //         return redirect()->route('history')->withError('Riwayat Tidak ditemukan');
    //     }

    //     $history->delete();

    //     return redirect()->route('history')->withSuccess(' Data Riwayat Berhasil dihapus');
    // }
}
