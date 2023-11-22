<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class authController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'class' => 'required',
            'school_name' => 'required',
            'password' => 'required|confirmed|min:6'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'class' => $request->class,
            'school_name' => $request->school_name,
            'password' => Hash::make($request->password),
            'level' => 'User',
        ]);

        Alert::success('Registrasi Berhasil!', 'Silahkan Login')->autoclose(3000);

        return redirect()->route('login');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('logout');
        }

        // Jika pengguna sudah logout, maka tampilkan halaman login
        return view('auth.login');
    }


    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->level === 'Admin') {
                return redirect()->route('dashboard');
            } elseif ($user->level === 'User') {
                return redirect()->route('userlogin');
            } elseif ($user->level === 'Counselor') {
                return redirect()->route('counselorlogin');
            }
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('login');
    }

    public function profile()
    {
        return view('auth/profile');
    }

    public function updateprofile(Request $request)
    {
        $user = auth()->user(); // Mengambil pengguna yang sedang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'class' => 'required',
            'school_name' => 'required|string|max:255'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->class = $request->class;
        $user->school_name = $request->school_name;
        $user->save();

        return redirect()->route('profile')->withSuccess('Profile Berhasil Diubah!');
    }
    public function updatepassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile')->withSuccess('Password Berhasil Diubah!');
    }

    public function profileuser()
    {
        return view('userlogin/auth/profileuser');
    }

    public function updateprofileuser(Request $request)
    {
        $user = auth()->user(); // Mengambil pengguna yang sedang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'class' => 'required',
            'school_name' => 'required|string|max:255'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->class = $request->class;
        $user->school_name = $request->school_name;
        $user->save();

        return redirect()->route('profileuser')->withSuccess('Profile Berhasil Diubah!');
    }
    public function updatepassworduser(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profileuser')->withSuccess('Password Berhasil Diubah!');
    }

    public function profilecounselor()
    {
        return view('counselorlogin/auth/profilecounselor');
    }

    public function updateprofilecounselor(Request $request)
    {
        $user = auth()->user(); // Mengambil pengguna yang sedang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'class' => 'required',
            'school_name' => 'required|string|max:255'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->class = $request->class;
        $user->school_name = $request->school_name;
        $user->save();

        return redirect()->route('profilecounselor')->withSuccess('Profile Berhasil Diubah!');
    }

    public function updatepasswordcounselor(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profilecounselor')->withSuccess('Password Berhasil Diubah!');
    }

    public function forgotPassword()
    {
        return view('auth.forgotpassword');
    }
}