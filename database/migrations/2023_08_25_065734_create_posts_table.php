<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('slug')->unique();
            // karena slug tidak boleh sama dan akan menjadi URL
            $table->string('image')->nullable();
            // menggunakan string karena hanya path nya saja yang disimpan (hasil dari return $request->file('image')->store('post-images');)
            // sedangkan file gambarnya akan disimpan di dalam directory
            $table->text('excerpt');
            $table->text('body');
            $table->timestamp('publish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
