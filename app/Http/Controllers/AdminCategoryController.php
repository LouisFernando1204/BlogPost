<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Providers\AppServiceProvider;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Dalam setiap function di dalam AdminCategoryController ini harus diberi if() di bawah ini untuk mencegah user yang belum login dan user selain admin yg sudah ditentukan.
        // namun kita bisa membuat middleware sendiri, kemudian masukkan if() ini ke dalam function handle() dan daftarkan middleware nya di Kernel.php
        // jika sudah, tinggal declare ->middleware('admin') di route nya 

        // ini untuk cek usernya kalau belum login maka keluarin pesan forbidden
        // dilakukan ini karena di route nya tidak diberi middleware() lagi
        // dan untuk cek kalau adminnya bukan admin yang sudah ditentukan maka keluarin pesan abort.
        // if (auth()->guest() || auth()->user()->username !== 'louisfernando') {
        //     abort(403);
        //     // ini adalah pesan forbidden/terlarang karena belum login
        // }
        // bisa juga pakai !auth()->check()
        // dikasi !(not) karena kalau check akan menghasilkan true kalau sudah login


        // JIKA MENGGUNAKAN GATE UNTUK AUTHORIZATION!!!
        // kalau pakai middleware di route, maka tidak perlu authorization di dalam function index ini
        $this->authorize('admin');
        // ini akan mengeluarkan pesan abort 403 juga tapi beda konteks
        // isikan authorize() dengan nama gate yang sudah dibuat di AppServiceProvider.php
        return view(
            'dashboard.categories.index',
            [
                "categories" => Category::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}