@extends('layouts.login')

@section('content')

    <!-- page -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="page">

            <!-- page-content -->
            <div class="page-content">
                <div class="container text-center text-dark">
                    <div class="row">

                        <div class="col-lg-4 d-block mx-auto">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center mb-6">
                                                <img src="/assets/images/brand/logo.png" class="" alt="">
                                            </div>
                                            <h3>Login</h3>
                                            <p class="text-muted">Informe suas credenciais</p>
                                            <div class="input-group mb-3">
                                                <span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
                                                <input type="text" name="email" class="form-control" placeholder="Usuário">
                                            </div>

                                            @error('email')
                                                <div class="input-group mb-3">
                                                    <label style="color: red;">{{ $message }}</label>
                                                </div>
                                            @enderror

                                            <div class="input-group mb-4">
                                                <span class="input-group-addon bg-white"><i
                                                        class="fa fa-unlock-alt"></i></span>
                                                <input type="password" name="password" class="form-control" placeholder="Senha">
                                            </div>

                                            @error('password')
                                                <div class="input-group mb-3">
                                                    <label style="color: red;">{{ $message }}</label>
                                                </div>
                                            @enderror

                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                                </div>
                                                <div class="col-12">
                                                    <a href="{{ route('password.request') }}"
                                                        class="btn btn-link box-shadow-0 px-0">Esqueci minha senha</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <!-- page-content end -->
        </div>
    </form>
@endsection
