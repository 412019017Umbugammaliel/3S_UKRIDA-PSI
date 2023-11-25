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
            ->orderBy('classifications.id', 'desc')
            ->select('classifications.*', 'categories.name_category')
            ->get();

        $categories = Category::all();

        return view('pageclassification.index', compact('classifications', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pageclassification.add_classification_modal', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|exists:categories,id_category',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::findOrFail($request->id_category);

        $classification = new Classification;
        $classification->title = $request->title;
        $classification->description = $request->description;

        $classification->category()->associate($category);

        $classification->save();

        return redirect()->route('pageclassification')->withSuccess('Berhasil Menambahkan Pertanyaan Baru!');
    }

    public function show($id)
    {
        $classification = Classification::findOrFail($id);

        return view('pageclassification.index', compact('classification'));
    }

    public function edit($id)
    {
        $classification = Classification::findOrFail($id);
        $categories = Category::all();

        return view('pageclassification.classification_modal', [
            'editMode' => true,
            'classification' => $classification,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|exists:categories,id_category',
            'title' => 'required',
            'description' => 'required',
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
        $classification->title = $request->title;
        $classification->description = $request->description;

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

        $classification->delete();

        return redirect()->route('pageclassification')->withSuccess('Data Klasifikasi berhasil dihapus');
    }
}

