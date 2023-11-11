<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{
    public function index()
    {
        $content = Content::orderBy('id', 'desc')->get();

        return view('pagecontent.index', compact('content'));
    }

    public function create()
    {
        return view('pagecontent.content_modal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:contents',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                'title' => ['Title sudah ada dalam database.'],
            ]);
        }

        $content = new Content;
        $content->title = $request->title;
        $content->description = $request->description;
        $content->image = $request->image;
        $content->save();

        if ($request->hasFile('image')) {
            $namaFile = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move('images/', $namaFile);
            $content->image = $namaFile;
            $content->save();
        }

        // Redirect back with a success message
        return redirect()->route('pagecontent')->withSuccess('Berhasil Menambahkan Content!');
    }

    public function show($id)
    {
        // Mengambil data Konten berdasarkan ID
        $content = Content::find($id);

        // Periksa apakah Konten ditemukan
        if (!$content) {
            return redirect()->route('pagecontent')->with('error', 'Content tidak ditemukan');
        }

        return view('pagecontent.index', ['content' => $content]);
    }

    public function edit($id)
    {
        $content = Content::find($id);
        if (!$content) {
            return redirect()->route('pagecontent')->with('error', 'content tidak ditemukan');
        }
        return view('pagecontent.index', ['content' => $content]);
    }

    public function updatecontent(Request $request, $id)
    {
        // Validasi data yang diterima dari permintaan
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mengambil data content berdasarkan ID
        $content = Content::find($id);

        // Periksa apakah Konten ditemukan
        if (!$content) {
            return response()->json(['error' => false, 'message' => 'Konten tidak ditemukan'], 404);
        }

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $content->image = $imageName;
        }

        // Memperbarui data Konten berdasarkan data yang diterima dari permintaan
        $content->title = $request->input('title');
        $content->description = $request->input('description');
        $content->save();

        return response()->json(['success' => true, 'message' => 'Data Konten berhasil diperbarui']);
    }


    public function destroy($id)
    {
        // Temukan Konten berdasarkan ID dan hapus
        $content = Content::find($id);
        $content->delete();

        // Redirect ke halaman yang sesuai setelah penghapusan
        return response()->json(['success' => true, 'message' => 'Data content berhasil Dihapus']);
    }
}
