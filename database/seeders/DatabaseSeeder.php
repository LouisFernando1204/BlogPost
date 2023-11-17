<?php
// FAKER SUDAH BAWAAN DARI LARAVEL NYA TERNYATA, JADI TIDAK HARUS DOWNLOAD PAKE COMPOSER SEPERTI SEBELUMNYA!!!
// *notes: kita bisa membuat model yang disertai langsung dengan migrations, factories, dan juga seeder nya dengan cara berikut:
// php artisan make:model -mfs
// semua nama file sudah sesuai dengan ketentuan default yang ada di laravel, misal:
// create_posts_table
// PostFactory
// PostSeeder

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ini akan men-generate 10 baris data random untuk table user, terisi semua kolom/field nya.
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // kalau semisal kita tuliskan perintah php artisan db:seed lagi maka tidak bisa berjalan karena ada kolom yang sudah ditentukan unique(), jadi semisal mau menambah data maka harus migrate fresh dulu terus baru jalankan seed nya
        // intinya adalah didrop dulu semua table nya terus dibuat lagi, baru diisi semua datanya (atau bisa dicomment dulu table-table lain yang tidak ikut ditambahkan datanya, jadi hanya table yang ingin ditambah saja, kemudian php artisan db:seed)


        // INI SEBELUM MENGGUNAKAN FACTORY dan FAKER, jadi masih generate manual!!
        // User::create([
        //     'name' => 'Sandhika Galih',
        //     'email' => 'sandhikagalih@gmail.com',
        //     'password' => bcrypt('12345'),
        // ]);
        User::create([
            'name' => 'Louis Fernando',
            'username' => 'louisfernando',
            'email' => 'fernandolouis55@gmail.com',
            'password' => bcrypt('12345'),
        ]);
        // Post::create([
        //     'title' => 'Judul Pertama',
        //     'slug' => 'judul-pertama',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, consequatur soluta atque id praesentium eum nihil explicabo? Voluptatum, iste mollitia?',
        //     'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad voluptatem error reprehenderit, praesentium quis temporibus cumque esse quidem corporis fugiat. aut nihil nemo repellat a beatae minus iusto voluptates sunt magnam labore itaque amet similique eius! Iure neque libero corporis tenetur. necessitatibus voluptate ipsam qui cum corrupti eveniet nam dolor, error quas repellendus ullam, facilis, similique praesentium ea. Architecto ullam necessitatibus ex nulla ducimus nihil porro, deserunt saepe corrupti iusto omnis molestiae? Porro, cumque consequatur assumenda alias nobis voluptate asperiores voluptatibus, ad minima animi dolores repellendus minus! Quibusdam harum laboriosam veniam est quaerat facilis labore reiciendis cumque sint dolor, vero dignissimos similique vel nihil, asperiores eaque. Commodi nulla fugit dolor sunt iusto ab quam temporibus beatae neque iure, ipsam eligendi?',
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);
        // Post::create([
        //     'title' => 'Judul Ke Dua',
        //     'slug' => 'judul-ke-dua',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, consequatur soluta atque id praesentium eum nihil explicabo? Voluptatum, iste mollitia?',
        //     'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad voluptatem error reprehenderit, praesentium quis temporibus cumque esse quidem corporis fugiat. aut nihil nemo repellat a beatae minus iusto voluptates sunt magnam labore itaque amet similique eius! Iure neque libero corporis tenetur. necessitatibus voluptate ipsam qui cum corrupti eveniet nam dolor, error quas repellendus ullam, facilis, similique praesentium ea. Architecto ullam necessitatibus ex nulla ducimus nihil porro, deserunt saepe corrupti iusto omnis molestiae? Porro, cumque consequatur assumenda alias nobis voluptate asperiores voluptatibus, ad minima animi dolores repellendus minus! Quibusdam harum laboriosam veniam est quaerat facilis labore reiciendis cumque sint dolor, vero dignissimos similique vel nihil, asperiores eaque. Commodi nulla fugit dolor sunt iusto ab quam temporibus beatae neque iure, ipsam eligendi?',
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);
        // Post::create([
        //     'title' => 'Judul Ke Tiga',
        //     'slug' => 'judul-ke-tiga',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, consequatur soluta atque id praesentium eum nihil explicabo? Voluptatum, iste mollitia?',
        //     'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad voluptatem error reprehenderit, praesentium quis temporibus cumque esse quidem corporis fugiat. aut nihil nemo repellat a beatae minus iusto voluptates sunt magnam labore itaque amet similique eius! Iure neque libero corporis tenetur. necessitatibus voluptate ipsam qui cum corrupti eveniet nam dolor, error quas repellendus ullam, facilis, similique praesentium ea. Architecto ullam necessitatibus ex nulla ducimus nihil porro, deserunt saepe corrupti iusto omnis molestiae? Porro, cumque consequatur assumenda alias nobis voluptate asperiores voluptatibus, ad minima animi dolores repellendus minus! Quibusdam harum laboriosam veniam est quaerat facilis labore reiciendis cumque sint dolor, vero dignissimos similique vel nihil, asperiores eaque. Commodi nulla fugit dolor sunt iusto ab quam temporibus beatae neque iure, ipsam eligendi?',
        //     'category_id' => 2,
        //     'user_id' => 1
        // ]);
        // Post::create([
        //     'title' => 'Judul Ke Empat',
        //     'slug' => 'judul-ke-empat',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, consequatur soluta atque id praesentium eum nihil explicabo? Voluptatum, iste mollitia?',
        //     'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad voluptatem error reprehenderit, praesentium quis temporibus cumque esse quidem corporis fugiat. aut nihil nemo repellat a beatae minus iusto voluptates sunt magnam labore itaque amet similique eius! Iure neque libero corporis tenetur. necessitatibus voluptate ipsam qui cum corrupti eveniet nam dolor, error quas repellendus ullam, facilis, similique praesentium ea. Architecto ullam necessitatibus ex nulla ducimus nihil porro, deserunt saepe corrupti iusto omnis molestiae? Porro, cumque consequatur assumenda alias nobis voluptate asperiores voluptatibus, ad minima animi dolores repellendus minus! Quibusdam harum laboriosam veniam est quaerat facilis labore reiciendis cumque sint dolor, vero dignissimos similique vel nihil, asperiores eaque. Commodi nulla fugit dolor sunt iusto ab quam temporibus beatae neque iure, ipsam eligendi?',
        //     'category_id' => 2,
        //     'user_id' => 2
        // ]);


        User::factory(3)->create();
        // // ini untuk membuat 5 user Indonesia secara random, setting dulu di bagian folder config/app.php dan .env

        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming',
        ]);
        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design',
        ]);
        Category::create([
            'name' => 'Personal',
            'slug' => 'personal',
        ]);

        Post::factory(20)->create();
    }
}
