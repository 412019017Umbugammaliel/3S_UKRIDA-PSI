<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::orderBy('id', 'desc')->get();

        return view('userdata.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('userdata.add_user_modal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'class' => 'required',
            'school_name' => 'required',
            'level' => 'required|in:Admin,Counselor,User',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah ada dalam database.'],
            ]);
        }

        // Create a new user
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'class' => $request->input('class'),
            'school_name' => $request->input('school_name'),
            'password' => $request->input('password'),
            'level' => $request->input('level'),
        ]);

        // Redirect back with a success message
        return redirect()->route('userdata')->withSuccess('Berhasil Menambahkan User!');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data pengguna berdasarkan ID
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return redirect()->route('userdata')->with('error', 'Pengguna tidak ditemukan');
        }

        return view('userdata.index', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mengambil data pengguna berdasarkan ID
        $user = User::find($id);
        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return redirect()->route('userdata')->with('error', 'Pengguna tidak ditemukan');
        }
        return view('userdata', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari permintaan
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'class' => 'required',
            'school_name' => 'required',
            'level' => 'required',
        ]);
        // Mengambil data pengguna berdasarkan ID
        $user = User::find($id);
        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return redirect()->route('userdata')->with('error', 'Pengguna tidak ditemukan');
        }
        // Memperbarui data pengguna berdasarkan data yang diterima dari permintaan
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->class = $request->input('class');
        $user->school_name = $request->input('school_name');
        $user->level = $request->input('level');
        $user->save();
        return response()->json(['success' => true, 'message' => 'Data pengguna berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan pengguna berdasarkan ID dan hapus
        $user = User::find($id);
        $user->delete();

        // Redirect ke halaman yang sesuai setelah penghapusan
        return response()->json(['success' => true, 'message' => 'Data pengguna berhasil Dihapus']);
    }
}
