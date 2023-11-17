{{-- dump and die: fungsinya sama seperti var_dump() untuk melihat isi variable, objek, array.
    die di sini untuk memberhentikan kode di bawahnya sehingga yg berjalan hanya @dd saja--}}
{{-- @dd($posts) --}}

{{-- notes: nantinya untuk mengeluarkan hasil dari table nya tidak lagi menggunakan notasi array ([]) tapi menggunakan notasi objek(->). --}}
{{-- jadi collection memperbolehkan kita untuk mengakses melalui notasi array ataupun notasi objek, mangkannya ngga error --}}

@extends('layout.main')

@section('container')
    <h1>{{ $title }}</h1>
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4">
                <a href="/posts?category={{ $category->slug }}">
                    <div class="card text-bg-dark border-0">
                        <img src="https://source.unsplash.com/500x500?{{ $category->name }}" class="card-img" alt="{{ $category->name }}">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
                            <h5 class="card-title text-center">{{ $category->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection

