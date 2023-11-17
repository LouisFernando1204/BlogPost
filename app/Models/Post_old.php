<?php

namespace App\Models;

class Post_old
{
    private static $blog_posts = [
        [
            "title" => "Judul Post Pertama",
            "slug" => "judul-post-pertama",
            "author" => "Sandhika Galih",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Provident inventore eligendi saepe, laboriosam repellendus aliquid. 
            Rem perferendis, voluptas dicta, neque labore ipsum a vitae, unde ad 
            velit quasi nostrum! Dolores possimus atque, suscipit, velit quisquam illo 
            eligendi id repellat voluptate fugit adipisci quas sint earum harum odio 
            modi ea tempora minima, doloremque consequatur quae omnis tempore error. 
            Saepe vel distinctio placeat tempore unde exercitationem optio excepturi 
            corrupti eligendi nihil? Nostrum illum accusamus mollitia qui vero assumenda 
            ad fugiat voluptas enim, omnis, eius nam recusandae! Tempora ratione et adipisci
            dolorem cum placeat error eligendi, sint vel expedita ex asperiores animi doloribus?"
        ],
        [
            "title" => "Judul Post Kedua",
            "slug" => "judul-post-kedua",
            "author" => "Louis Fernando",
            "body" => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
            Cumque nostrum, natus repudiandae est quasi voluptatem rerum cum accusamus, 
            animi, quos minima aspernatur pariatur iure molestiae. Repellendus, odio laborum. 
            Rerum consequuntur quod delectus, sit repellendus omnis corporis et odio animi? 
            Natus in reiciendis distinctio molestiae ullam, modi nihil possimus atque quia 
            asperiores sint dolorum laboriosam sequi tempora fugit dolore? Commodi veritatis 
            repudiandae consequuntur dolore soluta architecto esse non numquam beatae culpa velit, 
            adipisci quos illum at nisi natus distinctio aut. Dolorem?"
        ]
    ];
    public static function all()
    {
        // kalau property biasa (bukan static) berarti pakai $this->$blog_posts
        // pakai self untuk akses property static
        // pakai static untuk akses function static
        return collect(self::$blog_posts);
    }
    public static function find($slug)
    {
        $posts = static::all();
        //ini contoh kalau ngga pakai collect:
        // $posts = self::$blog_posts;
        // $post = [];
        // foreach ($posts as $p) {
        //     if ($p['slug'] == $slug) {
        //         $post = $p;
        //     }
        // }
        //return $post;
        return $posts->firstWhere('slug', $slug);
    }
}