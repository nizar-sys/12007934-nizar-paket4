@extends('layouts.auth')
@section('title', 'Register')

@section('content')
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <h1 class="text-white">Selamat datang!</h1>
                            <p class="text-lead text-white">Silahkan masuk untuk melanjutkan ke aplikasi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form role="form" action="{{ url('/register', []) }}" method="POST">
                                @csrf

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" name="name" placeholder="Nama Lengkap" type="name"
                                            value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" name="email" placeholder="Email" type="email"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input class="form-control" name="no_telp" placeholder="No telepon" type="no_telp"
                                            value="{{ old('no_telp') }}">
                                    </div>
                                    @error('no_telp')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="password" placeholder="Password" type="password"
                                            value="{{ old('password') }}" id="password">
                                        <div class="input-group-prepend">
                                            <button type="button" onclick="seePassword(this)" class="input-group-text"
                                                id="seePass"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
