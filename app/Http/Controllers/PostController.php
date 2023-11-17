<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

// ini bisa juga menggunakan expand class langsung di bagian Post nya di bawah
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $addonTitle = '';
        if (request('category')) {
            $category = Category::where('slug', request('category'))->first();
            $addonTitle = ' in ' . $category->name;
        }
        if (request('author')) {
            $author = User::where('username', request('author'))->first();
            $addonTitle = ' by ' . $author->name;
        }

        return view(
            'posts',
            [
                "title" => "All Posts" . $addonTitle,
                "active" => "posts",
                // "posts" => \App\Models\Post::all()
                "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString(),
                // withQueryString() ini digunakan agar ketika misalnya di halaman kategori tertentu
                // kemudian next ke halaman selanjutnya dari kategori tersebut tidak malah ke reset/kembali
                // ke halaman post semuanya.
                // awalnya letak with(); ada di sini cuma bisa juga diletakkan di dalam model Post nya.
                // ini disebut EAGER LOADING!!!
                // ini langsung mengambil data author serta category nya sekalian ketika looping query Post nya (parent). jadi tidak looping lagi setelah query parentnya untuk cari masing" author dan category yang sesuai dengan post
                "authors" => User::all(),
                "categories" => Category::all()
            ]
        );
    }
    public function show(Post $post)
    // parameter $slug ini akan menerima nilai yang diambil dari URL
    {
        return view(
            'post',
            [
                "title" => "Single Post",
                "active" => "posts",
                "post" => $post
            ]
        );
    }
}
