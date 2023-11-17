<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'dashboard.posts.index',
            [
                "posts" => Post::where('user_id', auth()->user()->id)->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'dashboard.posts.create',
            [
                "categories" => Category::all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // SIMULASI PENYIMPANAN FILE DI LARAVEL!

        // return $request->file('image')->store('post-images');
        // ini akan mengembalikan path selain memasukkan/meng-upload filenya
        // post-images/ojOGbVj8gCptSvLebCoGi3xSmBGHIFmeNiTYduAc.png

        // foto ini awalnya akan masuk ke dalam storage/app/post-images, untuk dapat diakses
        // public maka harus dimasukkan ke dalam storage/app/public

        // namun ketika coba diakses relative pathnya maka tetap tidak bisa karena kita harus
        // menghubungkan dengan folder public yang isinya css, js, dll yang dapat diakses secara
        // public oleh user dengan menggunakan symbolic link yaitu php artisan storage:link

        // maka di folder public akan ada folder storage dengan tanda panah yg artinya terhubung dengan
        // folder storage/public/post-images

        $validatedData = $request->validate([
            "title" => "required|max:255",
            "slug" => "required|unique:posts",
            // ini untuk menjaga biar slug tetap unik meskipun user mengganti slug sesuai dengan keinginannya sendiri
            "category_id" => "required",
            // ini biar data category_id di validated data nya masuk sehingga bisa langsung dimasukkan ke dalam table posts
            "image" => "image|file|max:1024",
            // ini diberi file dulu sebelum max biar max nya dianggep dalam bentuk kilobyte, kalau tidak diberi file maka akan dianggap panjang karakter string
            "body" => "required"
        ]);

        // ini untuk mengambil path nya saja yg akan dimasukkan ke dalam database, kemudian store file gambar aslinya ke dalam folder public/storage
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($validatedData['body']), 200);
        // strip_tags() ini digunakan untuk menghilangkan style bold, italic dan lain-lainnya yang kemungkinan dipakai oleh user di trix editor

        Post::create($validatedData);

        return redirect('/dashboard/posts')->with('create_success', 'New Post has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view(
            'dashboard.posts.show',
            [
                "post" => $post
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view(
            'dashboard.posts.edit',
            [
                "post" => $post,
                "categories" => Category::all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            "title" => "required|max:255",
            "category_id" => "required",
            "image" => "image|file|max:1024",
            "body" => "required"
        ];

        // ini buat jaga biar kalau misal usernya update title kemudian slug nya juga ke update, maka jalanin validasi ini.
        // tapi kalau semisal ngga update slug nya, berarti ngga usah divalidasi sehingga bisa langsung diupdate
        if ($request->slug != $post->slug) {
            $rules['slug'] = "required|unique:posts";
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            // ini buat ngilangin file gambar lama yang sudah diupdate sehingga tidak menuh"in
            // cek dulu apa ada image lama nya atau tidak, karena dari awal image ini nullable() jadi bisa jadi user tidak upload sama sekali gambarnya
            if($request->oldImage) {
                Storage::delete($request->oldImage);
                // ini yang di delete adalah path dari image nya
            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($validatedData['body']), 200);
        // strip_tags() ini digunakan untuk menghilangkan style bold, italic dan lain-lainnya yang kemungkinan dipakai oleh user di trix editor

        Post::where('id', $post->id)
                ->update($validatedData);

        return redirect('/dashboard/posts')->with('update_success', "{$post->title} has been successfuly updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // ini buat cek kalo semisal ada user yang punya gambar di post nya, maka ketika mau menghapus 1 post nya, maka gambar yang ada di folder juga akan dihapus
        if($post->image) {
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('delete_success', "{$post->title} has been successfuly deleted!");
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
