<?php
// models ini diartikan sebagai representasi dari table yang ada di codingan kita
// jadi ketika kita mau ambil data / mengolah data harus menggunakan model ini sebagai objek table nya
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // field mana saja yang boleh diisi dan sisanya akan diisi oleh Laravel.
    // protected $fillable = [
    //     'name',
    //     'username',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}


// TINKER adalah sebuah aplikasi dalam laravel untuk berinteraksi dengan aplikasi laravel.

// di TINKER kita dapat menggunakan perintah help seperti: php artisan help make:model (bisa juga digunakan ketika hendak membuat controller)
// PS C:\xampp\htdocs\belajar_laravel> php artisan tinker
// Psy Shell v0.11.20 (PHP 8.2.4 — cli) by Justin Hileman
// > $user = new App\Models\User;
// = App\Models\User {#6253}
// --> inisiasi objek $user yang instance dari model yaitu User.

// > $user = new User;
// [!] Aliasing 'User' to 'App\Models\User' for this Tinker session.
// = App\Models\User {#6254}
// --> dapat juga langsung menuliskan nama modelnya,
// dimana laravel akan otomatis/default menjalankan model tersebut jika sudah berada di dalam folder App\Models.

// >
// > $user->name = 'Louis Fernando';
// = "Louis Fernando"

// > $user->email = 'louis@gmail.com';
// = "louis@gmail.com"

// > $user->password = bcrypt('12345');
// = "$2y$10$bZpY7dwAFG5eFJwSg5pWgeeO9yjBHKSZdAak5Hy20tH3VfPJRtjB."

// > $user->save();
// = true
// --> harus melakukan save terlebih dahulu agar data yang dibuat dapat dimasukkan ke
// database MySQL / DBMS yang dipakai.

// > $user->all();
// = Illuminate\Database\Eloquent\Collection {#6954
//     all: [
//       App\Models\User {#7211
//         id: 1,
//         name: "Louis Fernando",
//         email: "louis@gmail.com",
//         email_verified_at: null,
//         #password: "$2y$10$bZpY7dwAFG5eFJwSg5pWgeeO9yjBHKSZdAak5Hy20tH3VfPJRtjB.",
//         #remember_token: null,
//         created_at: "2023-08-24 13:01:50",
//         updated_at: "2023-08-24 13:01:50",
//       },
//     ],
//   }
// --> jadi ketika mencoba untuk menampilkan isi dari table User maka sudah dikembalikan
// dalam bentuk Collection yang mana kita dapat langsung menggunakan berbagai method bawaan dari Collection seperti all(), first(), firstWhere(), dll.

// misal buat data lagi!
// > $user = new User;
// = App\Models\User {#7212}

// > $user->name = 'Sandhika Galih';
// = "Sandhika Galih"

// > $user->email = 'sandhika@gmail.com';
// = "sandhika@gmail.com"

// > $user->password = bcrypt('54321');
// = "$2y$10$69Vi81UFE8CvC.VOvE4./u0KM5Q9qp/0I0taH011uI3fhZzqsxl9."

// > $user->save();
// = true

// > $user->all();
// = Illuminate\Database\Eloquent\Collection {#6253
//     all: [
//       App\Models\User {#7213
//         id: 1,
//         name: "Louis Fernando",
//         email: "louis@gmail.com",
//         email_verified_at: null,
//         #password: "$2y$10$bZpY7dwAFG5eFJwSg5pWgeeO9yjBHKSZdAak5Hy20tH3VfPJRtjB.",
//         #remember_token: null,
//         created_at: "2023-08-24 13:01:50",
//         updated_at: "2023-08-24 13:01:50",
//       },
//       App\Models\User {#7214
//         id: 2,
//         name: "Sandhika Galih",
//         email: "sandhika@gmail.com",
//         email_verified_at: null,
//         #password: "$2y$10$69Vi81UFE8CvC.VOvE4./u0KM5Q9qp/0I0taH011uI3fhZzqsxl9.",
//         #remember_token: null,
//         created_at: "2023-08-24 13:09:15",
//         updated_at: "2023-08-24 13:09:15",
//       },
//     ],
//   }

// > $user->first();
// = App\Models\User {#6592
//     id: 1,
//     name: "Louis Fernando",
//     email: "louis@gmail.com",
//     email_verified_at: null,
//     #password: "$2y$10$bZpY7dwAFG5eFJwSg5pWgeeO9yjBHKSZdAak5Hy20tH3VfPJRtjB.",
//     #remember_token: null,
//     created_at: "2023-08-24 13:01:50",
//     updated_at: "2023-08-24 13:01:50",
//   }
// --> first() akan mengambil data pertama/indeks yang pertama dari table User

// > $user->find(2);
// = App\Models\User {#6248
//     id: 2,
//     name: "Sandhika Galih",
//     email: "sandhika@gmail.com",
//     email_verified_at: null,
//     #password: "$2y$10$69Vi81UFE8CvC.VOvE4./u0KM5Q9qp/0I0taH011uI3fhZzqsxl9.",
//     #remember_token: null,
//     created_at: "2023-08-24 13:09:15",
//     updated_at: "2023-08-24 13:09:15",
//   }
// --> find() akan menerima parameter yaitu id dari baris data yang ada di dalam table User, untuk mencari baris data dengan id tertentu.

// > $user->find(2000);
// = null

// > $user->findOrFail(2000);
//   Illuminate\Database\Eloquent\ModelNotFoundException  No query results for model [App\Models\User] 2000.
// --> findOrFail() akan menampilkan error message nya apa jika tidak didapatkan hasil query yaitu baris data yang diinginkan.
