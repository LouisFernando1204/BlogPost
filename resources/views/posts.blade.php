{{-- dump and die: fungsinya sama seperti var_dump() untuk melihat isi variable, objek, array.
    die di sini untuk memberhentikan kode di bawahnya sehingga yg berjalan hanya @dd saja--}}
{{-- @dd($posts) --}}

{{-- notes: nantinya untuk mengeluarkan hasil dari table nya tidak lagi menggunakan notasi array ([]) tapi menggunakan notasi objek(->). --}}
{{-- jadi collection memperbolehkan kita untuk mengakses melalui notasi array ataupun notasi objek, mangkannya ngga error --}}

{{-- pada defaultnya laravel melakukan lazy loading (penyebab N+1 PROBLEM) yang mana artinya adalah hanya melakukan proses jika kita mengakses property nya, tapi dengan eager load kita dapat langsung melakukan proses query di parent model nantinya
dimana ini sama seperti query php classic yaitu:
SELECT p.title, c.name, u.name FROM posts p, categories c, users u WHERE p.user_id = u.id AND p.category_id = c.id; --}}
{{-- CEK PAKAI CLOCKWORK!!! --}}


@extends('layout.main')

@section('container')
    <h1 class="mb-2 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-3">
      <div class="col-1">
        <form action="/posts" method="get">
          <div class="btn-group dropstart" role="group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Filter
            </button>
            <ul class="dropdown-menu p-2" style="width: 220px;">
              <li class="dropdown-header">Author</li>
              @foreach($authors as $author)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="author" value="{{ $author->username }}" id="flexCheckDefault"> {{ $author->name }}
              </div>
              @endforeach
              <li><hr class="dropdown-divider"></li>
              <li class="dropdown-header">Category</li>
              @foreach($categories as $category)
              <div class="form-check">
                <input class="form-check-input" type="checkbox"  name="category" value="{{ $category->slug }}" id="flexCheckDefault"> {{ $category->name }}
              </div>
              @endforeach
              <button class="btn btn-danger mt-3 mb-1" name="submit" type="submit">Save</button>
            </ul>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <form action="/posts" method="get">
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          @if(request('author'))
            <input type="hidden" name="author" value="{{ request('author') }}">
          @endif
            <div class="input-group mb-3">
              {{-- request() akan mengambil parameter-query (query parameters) yang dikirimkan melalui permintaan HTTP. --}}
              <input type="text" class="form-control" placeholder="Search.." name="search" value="{{ request('search') }}">
              <button class="btn btn-danger" type="submit">Search</button>
            </div>
        </form>
      </div>
    </div>

    @if($posts->count())
    <div class="card mb-4">
        @if($posts[0]->image)
          <div style="max-height: 280px; overflow: hidden;">
            <img src="{{ asset('storage/' . $posts[0]->image) }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">
          </div>
        @else
          <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">
        @endif
        <div class="card-body text-center">
          <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
          <p>
            <small class="text-body-secondary">
            By <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $posts[0]->author->name }}</a> in
            <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none">{{ $posts[0]->category->name }}</a> {{ $posts[0]->created_at->diffForHumans() }}
            {{-- diffForHumans() digunakan untuk menampilkan perbedaan waktu (selisih) sekarang dengan waktu dimana data itu awal terbuat. --}}
            </small>
          </p>
          <p class="card-text">{{ $posts[0]->excerpt }}</p>

          <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read More</a>
        </div>
    </div>

    <div class="container">
        <div class="row mb-5">
            @foreach($posts->skip(1) as $post)
            <div class="col-md-4 col-sm-2 mb-3">
                <div class="card">
                <div class="position-absolute px-2 py-2" style="background-color: rgba(0, 0, 0, 0.7);"><a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none text-white">{{ $post->category->name }}</a></div>
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->category->name }}" height="276px">
                @else
                  <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}">
                @endif
                    <div class="card-body">
                      <h5 class="card-title">{{ $post->title }}</h5>
                      <p>
                        <small class="text-body-secondary">
                        By <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> {{ $post->created_at->diffForHumans() }}
                        </small>
                      </p>
                      <p class="card-text">{{ $post->excerpt }}</p>
                      <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @else
    <p class="text-center fs-5" style="margin-top: 180px;">No post found.</p>
    @endif

    <div class="d-flex justify-content-center">
      {{ $posts->links() }}
    </div>
@endsection

