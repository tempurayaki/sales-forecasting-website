@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary" href="{{ route('admin.users.index') }}">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}"></use>
                </svg>
            </a>

            <form action="{{ route('admin.users.store') }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="name" class="form-label">{{ __('Nama') }}</label>

                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="email" class="form-label">{{ __('Email') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="password" class="form-label">{{ __('Password') }}</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Password') }}</label>

                        <input id="password_confirmation" type="password" class="form-control"
                            name="password_confirmation" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto text-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection