<?php
// untuk membuat table beserta field-field nya di dalam database, kita harus menggunakan migrations (jadi tidak langsung membuat table menggunakan CMD ataupun langsung di phpmyadmin)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // jadi ketika perintah php artisan migrate dijalankan maka function up akan dijalankan untuk membuat table di DBMS yang dipakai
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    // *penting: apabila mau update isi dari table, baik itu menambahkan/menghapus field dll maka
    // dapat menggunkan perintah php artisan migrate:fresh (untuk update --> drop dulu, terus baru create yang baru)
    // jadi ngga usah menjalankan php artisan migrate:rollback dan php artisan migrate, lebih efisien

    // NAMUN PERLU DIINGAT kalau di dalam table ada isi datanya kemudian di-migrate fresh berarti isinya juga hilang.

    // kalau semisal APP_ENV di file .env masih dalam tahap production dan kita coba untuk migrate maka
    // akan keluar peringatan terlebih dahulu kalau APPLICATION IN PRODUCTION!
    /**
     * Reverse the migrations.
     */
    // lalu, ketika perintah php artisan migrate:rollback maka function down ini akan dilakukan untuk drop/menghapus semua table yang sudah dibuat
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
