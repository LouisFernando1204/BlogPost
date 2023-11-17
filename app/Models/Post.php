<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory, Sluggable;

    // protected $fillable = ['title','excerpt','body'];

    // MASS ASSIGNMENT!!! -- kalau pakai mass assignment berarti tidak usah melakukan save() pada saat sudah menginputkan data karena akan otomatis terinput di dalam database
    // ini menandakan yang boleh diisi yaitu title, excerpt, dan body sehingga bisa langsung insert pakai method create seperti ini (tidak insert satu" seperti sebelumnya di model User):
    // $post::create([
    //     'title' => 'Judul Ke Empat',
    //     'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    //     'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad voluptatem error reprehenderit, praesentium quis temporibus cumque esse quidem corporis fugiat.</p> <p>aut nihil nemo repellat a beatae minus iusto voluptates sunt magnam labore itaque amet similique eius! Iure neque libero corporis tenetur.</p> <p>necessitatibus voluptate ipsam qui cum corrupti eveniet nam dolor, error quas repellendus ullam, facilis, similique praesentium ea. Architecto ullam necessitatibus ex nulla ducimus nihil porro, deserunt saepe corrupti iusto omnis molestiae? Porro, cumque consequatur assumenda alias nobis voluptate asperiores voluptatibus, ad minima animi dolores repellendus minus! Quibusdam harum laboriosam veniam est quaerat facilis labore reiciendis cumque sint dolor, vero dignissimos similique vel nihil, asperiores eaque. Commodi nulla fugit dolor sunt iusto ab quam temporibus beatae neque iure, ipsam eligendi?</p>'
    // ]
    // )
    // selain method create kita juga dapat menggunakan method lain seperti:
    // > $post::find(3)->update(['title' => 'Judul Ke Tiga Berubah'])
    // = true
    // ini akan mencari post yang id nya 3 terus titlenya diupdate.
    // > $post::where('title', 'Judul Ke Tiga Berubah')->update(['excerpt' => 'excerpt post 3 berubah'])
    // = 1
    // bedanya sama find kalau find hanya mencari berdasarkan id saja seperti select * from post where id = ... SEDANGKAN kalau pakai method where dapat mencari berdasarkan nama kolom yang lainnya.

    protected $guarded = ['id'];
    // ini kebalikannya dari $fillable dimana yang ngga boleh diisi yaitu id dan sisanya boleh, jadi biar kalau ada kolom baru tidak usah report menambahkan di $fillable
    protected $with = ['category', 'author'];
    // ini agar ketika menjalankan query posts nya sekalian mengambil category dan juga atuhor nya

    // sebenarnya bisa diletakkan langsung di dalam post controller, tapi sebenarnya tugas query ini adalah tugasnya model lalu yang request tugasnya controller.
    // ini digunakan untuk mem-filter apabila ada inputan search yang diinputkan oleh user, maka akan melalui query where ini terlebih dahulu.
    // penamaan function harus diawali scope____ kemudian terserah
    // function scopeFilter() ini berfungsi untuk membatasi user mencari post yang bukan termasuk dalam kategori/author yang sedang ditampilkan sekarang.
    public function scopeFilter($query, array $filters)
    {
        // if (isset($filters['search']) ? $filters['search'] : false) {
        //     return $query->where('title', 'LIKE', '%' . $filters['search'] . '%')
        //         ->orWhere('excerpt', 'LIKE', '%' . $filters['search'] . '%')
        //         ->orWhere('body', 'LIKE', '%' . $filters['search'] . '%');
        // }
        // ini sama saja jika menggunakan method when() seperti ini, fungsinya sama cuma beda penulisan
        // jika $filter['search'] ada isinya maka akan dijalankan function callback nya, namun jika tidak ada mengembalikan false.
        // operator null coalescing (??) artinya sama seperti contoh ternary di atas.
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('excerpt', 'LIKE', '%' . $search . '%')
                    ->orWhere('body', 'LIKE', '%' . $search . '%');
            });
        });

        // PENJELASAN kode di atas:
        // $filters['search'] ?? false adalah ekspresi yang menggunakan operator null coalescing (??).
        // Ini berarti jika 'search' ada dalam array $filters, maka $search akan diisi dengan nilai 'search'
        // dari array $filters. Jika 'search' tidak ada dalam array $filters, maka $search akan diisi
        // dengan false.

        // function ($query, $search) { ... } adalah fungsi penutup (closure) yang akan dijalankan
        // jika $filters['search'] ada (tidak null atau false). Jadi, $search dalam fungsi ini akan
        // menerima nilai dari 'search' dalam array $filters.

        // ini use ($category) biar $category yang dipakai sama dengan $category yang pertama
        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        // $query->when($filters['author'] ?? false, function ($query, $author) {
        //     return $query->whereHas('author', function ($query) use ($author) {
        //         $query->where('username', $author);
        //     });
        // });

        // ini kalo misal pake arrow function:
        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

    // di sini nama method nya disesuaikan dengan nama table/models yang ingin direlasikan dengan model saat ini
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // untuk mengganti nama function nya menjadi author, maka harus diberi parameter kedua yaitu foreign key mana yang menjadi penghubung antara table post dan user sehingga tidak error
    // jadi join antara table posts dan categories akan dijalankan di belakang layar oleh Laravel, kita bisa langsung menggunakannya saja
    // penentuan belongsTo atau Has itu bisa diketahui dari table yang memegang foreign key dari table lain (belongsTo), kalau table yang foreign key nya dipakai table lain (has).

    // ini untuk mengganti setiap route agar untuk mencari post didasarkan dengan slug bukan id, awalnya defaultnya yaitu id.
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ini untuk otomatis mengubah title yang diinputkan menjadi slug menggunakan package dari git (eloquent sluggable)
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    // untuk cek nya di artisan TINKER:
    // > $post = App\Models\Post::first();
    // = App\Models\Post {#7217
    // id: 1,
    // category_id: 1,
    // title: "Judul Pertama",
    // slug: "judul-pertama",
    // excerpt: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, consequatur soluta atque id praesentium eum nihil explicabo? Voluptatum, iste mollitia?",
    // body: "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad voluptatem error reprehenderit, praesentium quis temporibus cumque esse quidem corporis fugiat.</p> <p>aut nihil nemo repellat a beatae minus iusto voluptates sunt magnam labore itaque amet similique eius! Iure neque libero corporis tenetur.</p> <p>necessitatibus voluptate ipsam qui cum corrupti eveniet nam dolor, error quas repellendus ullam, facilis, similique praesentium ea. Architecto ullam necessitatibus ex nulla ducimus nihil porro, deserunt saepe corrupti iusto omnis molestiae? Porro, cumque consequatur assumenda alias nobis voluptate asperiores voluptatibus, ad minima animi dolores repellendus minus! Quibusdam harum laboriosam veniam est quaerat facilis labore reiciendis cumque sint dolor, vero dignissimos similique vel nihil, asperiores eaque. Commodi nulla fugit dolor sunt iusto ab quam temporibus beatae neque iure, ipsam eligendi?</p>",
    // publish: null,
    // created_at: "2023-08-25 12:39:25",
    // updated_at: "2023-08-25 12:39:25",
    // }

    // di sini kita sudah mendapatkan instance dari model category sehingga bisa mendapatkan isi dari data category yang terkait dengan post
    // > $post->category
    // = App\Models\Category {#7215
    // id: 1,
    // name: "Programming",
    // slug: "programming",
    // created_at: "2023-08-25 12:29:26",
    // updated_at: "2023-08-25 12:29:26",
    // }

    // > $post->category->name
    // = "Programming"
}

// dapat menggunakan method pluck() untuk mendapatkan semua baris data sesuai dengan nama kolom yang ditentukan di parameter
// Post::pluck('title')
// = Illuminate\Support\Collection {#6996
//     all: [
//       "Judul Pertama",
//       "Judul Ke Dua",
//     ],
//   }
