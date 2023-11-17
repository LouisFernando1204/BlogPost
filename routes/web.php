<?php

// kalau misal mau import dari model atau controller lain harus import lagi dengan cara yang sama
use App\Models\Post;
// import dr models sudah tidak dipakai lagi karena models sudah diakses di dalam controller masing-masing
use App\Models\User;
// untuk import controller sebenarnya juga bisa seperti model langsung expand class di bagian dalam routenya, tepat di nama file controllernya (klik kanan)
use App\Models\Category;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\AdminCategoryController;
use PHPUnit\Metadata\Api\HookMethods;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view(
        'home',
        [
            "title" => "Home",
            "active" => "home",
        ]
    );
});

Route::get('/home', function () {
    return view(
        'home',
        [
            "title" => "Home",
            "active" => "home",
        ]
    );
});

Route::get('/about', function () {
    return view(
        'about',
        [
            "title" => "About",
            "active" => "about",
        ],
        [
            "name" => "Louis Fernando",
            "email" => "louisfer@gmail.com",
            "image" => "gtr34.jpeg"
        ]
    );
})->middleware('auth');

// array $blog_posts ditaruh di dalam route milik blog agar bisa digunakan untuk mengirim datanya di dalam return.
Route::get('/posts', [PostController::class, 'index'])->middleware('auth');

//halaman single post
//pakai kurung kurawal yang disebut wild card untuk mengambil isi apapun yang ada di dalamnya
// {slug} adalah parameter dinamis yang akan mengambil nilai dari URL.
// Ketika Anda mendefinisikan {slug} dalam definisi route (posts/{slug}),
// itu berarti URL dapat memiliki bagian yang disebut "slug", dan nilainya
// akan diteruskan sebagai argumen ke fungsi yang Anda definisikan.
// $slug adalah parameter yang menerima nilai dari URL.
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->middleware('auth');
// ditambahkan :slug untuk mencari where slug = ...
// defaultnya kalau tanpa :slug maka akan mencari id nya langsung

// KENAPA NGGA PAKAI ID aja buat nyari post tertentunya?
// soalnya kalau id nanti usernya bisa nebak" langsung di URL nya tinggal diganti-ganti saja, mangkannya pakai slug

Route::get('/categories', function () {
    return view(
        'categories',
        [
            'title' => 'Post Categories',
            "active" => "categories",
            'categories' => Category::all()
        ]
    );
})->middleware('auth');


// ini sudah tidak terpakai karena sudah menggunakan route /posts di atas yang proses querynya
// untuk mendapatkan hasil post berdasarkan category dan author sudah dihandle oleh model Post
// Route::get('/categories/{category:slug}', function (\App\Models\Category $category) {
//     return view(
//         'posts',
//         [
//             'title' => "Post by Category : $category->name",
//             "active" => "categories",
//             'posts' => $category->posts->load('author', 'category')
//             // ini artinya LAZY EAGER LOADING. jadi karena menggunakan route model binding
//             // yang mana mendapatkan objeknya dulu baru dilakukan looping, maka cara untuk
//             // mengatasinya adalah melakukan load setelah mendapatkan objeknya sehingga table lain
//             // yang include juga ke-load saat itu juga.
//         ]
//     );
// });

// Route::get('/authors/{author:username}', function (User $author) {
//     return view(
//         'posts',
//         [
//             'title' => "Post by Author : $author->name",
//             "active" => "authors",
//             'posts' => $author->post->load('category', 'author')
//         ]
//     );
// });

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
// middleware('guest') artinya yaitu hanya bisa diakses jika user belum login, kalau sudah login maka akan diredirect ke halaman utama/home
// untuk mengganti redirect defaultnya ada di RouteServiceProvider.php
// penamaan route yaitu login ini adalah default dari laravel dimana laravel akan otomatis
// mengarahkan user ke halaman yang memiliki nama route yaitu login JIKA user mencoba mengakses halaman dengan middleware('auth'),
// bisa dicek di Authenticate.php

Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest');

Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/dashboard', function () {
    return view(
        'dashboard.index'
    );
})->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

// jadi dengan menggunakan method resource akan otomatis handle CRUD tanpa harus membuat route untuk masing-masing function yang ada di controlller seperti create(), store(), dll.
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

// Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');
// ini diberi except biar function show tidak dijalankan karena memang tidak digunakan, meskipun jika dibuka URL nya yaitu /dashboard/catgeories/{category} tidak akan menampilkan apa-apa.

// ini kalau misal otorisasi pakai gate saja
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show');
