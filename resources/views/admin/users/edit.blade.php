@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary" href="{{ route('admin.users.index') }}">
                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}"></use>
                </svg>
            </a>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="name" class="form-label">{{ __('Nama') }}</label>

                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name', $user->name) }}" required>

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
                            name="email" value="{{ old('email', $user->email) }}" required>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            Password tidak akan berubah jika dikosongkan. Gunakan tombol "Reset Password" di halaman daftar user untuk mereset password.
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection