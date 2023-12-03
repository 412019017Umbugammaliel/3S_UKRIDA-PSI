<?php

namespace App\Http\Controllers;

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
        $user = Auth::user();

        // Mendapatkan riwayat (history) yang terkait dengan pengguna yang sedang login
        $histories = DB::table('histories')
            ->join('users', 'histories.id_user', '=', 'users.id')
            ->where('histories.id_user', $user->id)
            ->select('histories.*', 'users.id as id_user', 'users.name as username')
            ->orderBy('histories.id', 'desc')
            ->get();

        $categories = Category::all();
        $users = User::all();

        return view('userlogin.history', compact('histories', 'categories', 'users'));
    }

    public function destroy($id)
    {
        $history = History::find($id);

        if (!$history) {
            return redirect()->route('history')->withError('Riwayat Tidak ditemukan');
        }

        $history->delete();

        return redirect()->route('history')->withSuccess(' Data Riwayat Berhasil dihapus');
    }
}
