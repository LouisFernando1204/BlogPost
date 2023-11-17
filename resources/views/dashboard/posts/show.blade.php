@extends('dashboard.layout.main')

@section('container')
<div class="container my-3">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">{{ $post->title }}</h1>
            <a href="/dashboard/posts" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back to all my posts</a>
            <form action="/dashboard/posts/{{ $post->slug }}/edit" method="get" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning text-white"><i class="bi bi-pencil-square" style="color: white;"></i> Edit</button>
            </form>
            <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle" style="color: white;" onClick="return confirm('Are you sure want to delete this post?')"></i> Delete</button>
            </form>
            @if($post->image)
                <div style="max-height: 280px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid mt-3">
                </div>
            @else
                <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid mt-3">
            @endif
            <article class="my-3">
                {!! $post->body !!}
            </article>
        </div>
    </div>
</div>
@endsection