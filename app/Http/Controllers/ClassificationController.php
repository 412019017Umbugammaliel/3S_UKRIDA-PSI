<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassificationController extends Controller
{
    public function index()
    {
        $classifications = DB::table('classifications')
            ->join('categories', 'classifications.id_category', '=', 'categories.id_category')
            ->join('users', 'classifications.id_user', '=', 'users.id')
            ->orderBy('classifications.id', 'desc')
            ->select('classifications.*', 'categories.name_category', 'users.name as user_name', 'users.email as user_email', 'users.class as user_class', 'users.school_name as user_school_name')
            ->get();

        $categories = Category::all();

        return view('pageclassification.index', compact('classifications', 'categories'));
    }


    private function getCategories()
    {
        return Category::all();
    }

    public function create()
    {
        $categories = $this->getCategories();
        return view('pageclassification.classification_modal', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_category' => 'required',
            'score' => 'required|integer|min:0|max:100',
            'conclusion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = Category::findOrFail($request->id_category);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['id_category' => 'Kategori tidak valid'])->withInput();
        }

        $classification = new Classification;
        $classification->score = $request->score;
        $classification->conclusion = $request->conclusion;

        $classification->user()->associate($request->id_user);
        $classification->category()->associate($category);

        $classification->save();

        return redirect()->route('pageclassification')->withSuccess('Berhasil Menambahkan Klasifikasi Baru!');
    }

    public function edit($id)
    {
        $classification = Classification::findOrFail($id);
        $categories = $this->getCategories();

        return view('pageclassification.classification_modal', [
            'editMode' => true,
            'classification' => $classification,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_category' => 'required',
            'score' => 'required|integer|min:0|max:100',
            'conclusion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = Category::findOrFail($request->id_category);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['id_category' => 'Kategori tidak valid'])->withInput();
        }

        $classification = Classification::findOrFail($id);
        $classification->score = $request->score;
        $classification->conclusion = $request->conclusion;

        $classification->user()->associate($request->id_user);
        $classification->category()->associate($category);

        $classification->save();

        return redirect()->route('pageclassification')->withSuccess('Klasifikasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $classification = Classification::find($id);

        if (!$classification) {
            return redirect()->route('pageclassification')->withError('Klasifikasi tidak ditemukan');
        }

        // Lakukan tindakan penghapusan di sini
        $classification->delete();

        return redirect()->route('pageclassification')->withSuccess('Klasifikasi berhasil dihapus');
    }
}
