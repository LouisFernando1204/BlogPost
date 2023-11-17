@extends('layout.main')
@section('container')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <h1 class="mb-3">{{ $post->title }}</h1>
                <p>By <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> in <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }}</a></p>
                @if($post->image)
                    <div style="max-height: 280px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">
                    </div>
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid">
                @endif
                <article class="my-3">
                    {!! $post->body !!}
                    {{-- ini biar tag html yang dimasukkan ke dalam kolom body dapat tereksekusi
                    kalau pakai php echo versi blade yaitu dengan {{  }} , maka akan menjalankan fungsi seperti
                    echo dan juga menggunakan htmlsepcialchars sehingga ada input tag html di inputan maka akan
                    dilewati/dianggap text biasa --}}
                </article>
            <a href="/posts" class="d-block mt-3 text-decoration-none">Back to Posts</a>
        </div>
    </div>
</div>
@endsection
