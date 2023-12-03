<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function getAllDataGroup()
    {
        $histories = DB::table('histories')
            // ->join('categories', 'histories.id_category', '=', 'categories.id_category')
            ->join('users', 'histories.id_user', '=', 'users.id')
            ->select('histories.*', 'users.id as id_user', 'users.name as username')
            ->orderBy('histories.id', 'desc')
            ->get();

        $categories = Category::all();
        $users = User::all();

        return view('pagehistory.index', compact('histories', 'categories', 'users'));
    }

    public function index()
    {
        return $this->getAllDataGroup();
    }

    public function historyuser()
    {
        return view('userlogin.history');
    }

    // public function create()
    // {
    //     $categories = $this->getCategories();
    //     $users = $this->getUsers();

    //     return view('pagehistory.history_modal', compact('categories', 'users'));
    // }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id_category' => 'required|exists:categories,id_category',
    //         'id_user' => 'required|exists:users,id',
    //         'final_point' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     History::create([
    //         'id_category' => $request->id_category,
    //         'id_user' => $request->id_user,
    //         'final_point' => $request->final_point,
    //     ]);

    //     return redirect()->route('pagehistory')->with('success', 'Berhasil menambahkan Jawaban!');
    // }

    // public function show($history)
    // {
    //     return view('pagehistory.index', ['history' => $history]);
    // }


    // public function edit($id)
    // {
    //     $history = History::findOrFail($id);
    //     $categories = Category::all();
    //     $users = User::all();

    //     return view('pagehistory.history_modal', ['editMode' => true, 'history' => $history, 'categories' => $categories, 'users' => $users]);
    // }

    // public function update(Request $request, $id)
    // {
    //     // Validation rules
    //     $validator = Validator::make($request->all(), [
    //         'id_category' => 'required|exists:categories,id_category',
    //         'id_user' => 'required|exists:users,id',
    //         'final_point' => 'required|numeric',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     try {
    //         $history = History::findOrFail($id);

    //         // Check if the history is found
    //         if (!$history) {
    //             return redirect()->route('pagehistory')->withError('History not found');
    //         }

    //         // Update the history attributes
    //         $history->id_category = $request->id_category;
    //         $history->id_user = $request->id_user;
    //         $history->final_point = $request->final_point;

    //         // Save the updated history
    //         $history->save();

    //         return redirect()->route('pagehistory')->withSuccess('Riwayat Berhasil diupdate');
    //     } catch (\Exception $e) {
    //         return redirect()->route('pagehistory')->withError('Terjadi Error ketika update History: ' . $e->getMessage());
    //     }
    // }

    public function destroy($id)
    {
        $history = History::find($id);

        if (!$history) {
            return redirect()->route('pagehistory')->withError('History not found');
        }

        $history->delete();

        return redirect()->route('pagehistory')->withSuccess(' Data Riwayat Berhasil dihapus');
    }

}
