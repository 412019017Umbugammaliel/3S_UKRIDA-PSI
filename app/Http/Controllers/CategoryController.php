<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('id_category', 'desc')->get();

        return view('pagecategory.index', compact('category'));
    }

    public function create()
    {
        return view('pagecategory.category_moal');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_category' => 'required',
            'image_category' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new Category;
        $category->name_category = $request->name_category;

        if ($request->hasFile('image_category')) {
            $namaFile = time() . '.' . $request->file('image_category')->extension();
            $request->file('image_category')->move('images/', $namaFile);
            $category->image_category = $namaFile;
        }

        $category->save();

        return redirect()->route('pagecategory')->withSuccess('Berhasil Menambahkan Kategori Baru!');
    }

    public function show($id_category)
    {
        $category = Category::findOrFail($id_category);
        if (!$category) {
            return redirect()->route('pagecategory')->withError('error', 'Kategori tidak ditemukan');
        }

        return view('pagecategory.index', ['category' => $category]);
    }

    public function edit($id_category)
    {
        $category = Category::find($id_category);
        if (!$category) {
            return redirect()->route('pagecategory')->withError('error', 'Kategory tidak ditemukan');
        }

        return view('pagecategory.index', ['category' => $category]);
    }

    public function updatecategory(Request $request, $id_category)
    {
        $this->validate($request, [
            'name_category' => 'required',
            'image_category' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::find($id_category);

        if (!$category) {
            return response()->json(['error' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->name_category = $request->input('name_category');

        if ($request->hasFile('image_category')) {
            $namaFile = time() . '.' . $request->file('image_category')->extension();
            $request->file('image_category')->move('images/', $namaFile);
            $category->image_category = $namaFile;
        }

        $category->save();

        return response()->json(['success' => true, 'message' => 'Data Kategori berhasil diperbarui']);
    }

    public function destroy($id_category)
    {
        $category = Category::find($id_category);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        // Hapus kategori
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Data Kategori berhasil Dihapus']);
    }

}
