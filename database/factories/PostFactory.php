<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2, 8)),
            // mt_rand untuk merandom bilangan.
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(),
            // paragraph defaultnya akan menghasilkan 3 kalimat random.
            // 'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(mt_rand(5, 10))) . '</p>',
            // implode di sini untuk memberikan tag <p> setiap ketemu array dari paragraph yang ter-generate karena faker paragraphs() akan mengembalikan sebuah array
            // atau bisa juga seperti ini:
            'body' => collect($this->faker->paragraphs(mt_rand(5, 10)))
                ->map(function ($p) {
                    return "<p>$p</p>";
                })
                ->implode(''),
            // -- map() disini digunakan untuk memetakan/menerapkan fungsi tertentu 
            // pada elemen collection yg sudah dibuat sebelumnya 
            // (dalam hal ini untuk membungkus paragraph nya di dalam tag p)
            // -- implode() untuk menggabungkan/join dengan parameter '' yang artinya 
            // kosongan (tanpa ada pemisah).

            // bisa juga seperti ini:
            // collect($this->faker->paragraphs(mt_rand(5, 10)))
            // ->map(fn($p)=>"<p>$p</p>")
            // ->implode(''),
            'user_id' => mt_rand(1, 4),
            'category_id' => mt_rand(1, 3)
        ];
    }
}
