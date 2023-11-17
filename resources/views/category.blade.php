{{-- dump and die: fungsinya sama seperti var_dump() untuk melihat isi variable, objek, array. 
    die di sini untuk memberhentikan kode di bawahnya sehingga yg berjalan hanya @dd saja--}}
{{-- @dd($posts) --}}

{{-- notes: nantinya untuk mengeluarkan hasil dari table nya tidak lagi menggunakan notasi array ([]) tapi menggunakan notasi objek(->). --}}
{{-- jadi collection memperbolehkan kita untuk mengakses melalui notasi array ataupun notasi objek, mangkannya ngga error --}}

@extends('layout.main')

@section('container')
    <h1>Post Category: {{ $category }}</h1>
    <br>
    @foreach($posts as $post)
    <article class="mb-5">
        <h2><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h2>
        <p>{{ $post->excerpt }}</p>
    </article>
    @endforeach
@endsection

