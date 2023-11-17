<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
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
            'register.index',
            [
                "title" => "Register",
                "active" => "register"
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        // kalau kita return hasilnya maka akan muncul page expired karena laravel akan langsung
        // mengamankan data kita yang dikirimkan melalui post.
        // karena secaa default laravel akan mengira itu adalah inputan dari website lain yang
        // mencoba membajak website kita, sehingga di setiap form harus diberi @csrf untuk men-generate
        // sebuah token yang akan digunakan untuk keamanan.

        // ini anggapannya sudah dalam bentuk array yang nantinya bisa langsung digunakan di method create() untuk membuat user baru.
        $validatedData = $request->validate([
            "name" => "required|max:255",
            "username" => ['required', 'min:3', 'max:255', 'unique:users'],
            "email" => "required|email:rfc,dns|unique:users",
            "password" => "required|min:5|max:255"
        ]);

        // $validatedData['password'] = bcrypt($validatedData['password']);
        // atau bisa juga menggunakan... sama" menggunakan metode enkripsi yaitu bcrypt.
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        // $request->session()->flash('registration_success', '<b>' . 'Registration successful! ' . '</b>' . 'Please Login!');
        // ini sama aja jika session nya dibarengin sama redirect/ditulis setelah redirect.
        return redirect('/login')->with('registration_success', '<b>' . 'Registration successful! ' . '</b>' . 'Please Login!');
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
