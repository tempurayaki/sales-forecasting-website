@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="container">
    <div class="d-flex justify-content-right mb-4">
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success text-light ml-1">
                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                Tambah User
            </a>            
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            @if (session()->has('success') || session()->has('failed'))
                <div class="row mb-4">
                    @if (session()->has('success'))
                        <div class="col-12">
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        </div>
                    @endif
                    @if (session()->has('failed'))
                        <div class="col-12">
                            <div class="alert alert-danger">
                                {{ session()->get('failed') }}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="font-weight-bold h5">Data User</div>
                    </div>
                </div>
                <div class="card-body p-0 overflow-auto">
                    <table class="table table-striped table-fixed">
                        <thead>
                            <tr class="sticky-top">
                                <th class="text-center w-15">{{ __('No') }}</th>
                                <th class="text-center w-25">{{ __('Nama') }}</th>
                                <th class="text-center w-25">{{ __('Email') }}</th>
                                <th class="text-center w-25">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr class="data-tables" data-id="{{ $user->id }}">
                                    <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + ($key + 1) }}</td>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm text-warning" title="Edit User">
                                                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                                                </svg>
                                            </a>
                                            <a href="#" class="btn btn-sm text-info" title="Reset Password"
                                            onclick="event.preventDefault(); if(confirm('Reset password untuk {{ $user->name }}?')) document.getElementById('resetPassword{{ $user->id }}').submit();">
                                                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                                                </svg>
                                            </a>
                                            <a href="#" class="btn btn-sm text-danger" title="Hapus User"
                                            onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus user ini?')) document.getElementById('deleteRow{{ $user->id }}').submit();">
                                                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                                                </svg>
                                            </a>
                                            <form id="resetPassword{{ $user->id }}" action="{{ route('admin.users.reset-password', $user->id) }}" 
                                                method="POST" class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <form id="deleteRow{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" 
                                                method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(isset($users) && count($users) === 0)
                        <div class="h-300">
                            <div class="text-center">
                                <div>Data tidak ditemukan</div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($users->hasPages())
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection