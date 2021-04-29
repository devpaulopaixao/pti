@extends('layouts.login')

@section('content')

<div class="card">

    <div class="card-body login-card-body">
      <p class="login-box-msg">Resetar senha</p>

      <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('email')
        <div class="input-group mb-3">
            <label style="color: red;">{{ $message }}</label>
        </div>
        @enderror

        <div class="input-group mb-3">
          <input id="password" name="password" type="password" class="form-control" placeholder="Nova senha" required autocomplete="new-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
        <div class="input-group mb-3">
            <label style="color: red;">{{ $message }}</label>
        </div>
        @enderror

        <div class="input-group mb-3">
          <input id="password-confirm" name="password-confirm" type="password" class="form-control" placeholder="Confirmar nova senha" required autocomplete="new-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Resetar senha</button>
          </div>
        </div>

      </form>

      @if (Route::has('password.request'))
      <p class="mb-1">
        <a href="{{ route('password.request') }}">Esqueci minha senha</a>
      </p>
      @endif

    </div>
  </div>

</div>
@endsection
