@extends('layout.main')

@section('container')
<div class="row justify-content-center">
    <div class="col-md-4">
      @if(session()->has('registration_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('registration_success') !!}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if(session()->has('login_error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('login_error') !!}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
        <main class="form-signin">
          <h1 class="h3 mb-3 fw-normal text-center fw-bold">Please Login</h1>
            <form action="/login" method="post">
              @csrf
              <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                <label for="email">Email address</label>
                @error('email')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
              </div>
          
              <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            </form>
            <small class="text-center d-block mt-3">Not Registered? <a href="/register">Register Now!</a></small>
        </main>
    </div>
</div>
@endsection