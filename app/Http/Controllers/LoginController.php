<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'login.index',
            [
                "title" => "Login",
                "active" => "login"
            ]
        );
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email:dns",
            "password" => "required"
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        // session harus diregenerate untuk mencegah ada user lain/hacker yang masuk ke dalam aplikasi kita dengan session yang sudah ada tanpa login.
        // intended() digunakan untuk skip middleware -> sebuah keamanan sebelum masuk ke dalam halaman utama/halaman lainnya dalam website kita

        return redirect()->back()->with('login_error', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        // kalau ngga mau declare Request $request di dalam parameter, maka dapat menggunakan request() langsung di dalam function. 
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}