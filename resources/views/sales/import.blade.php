@extends('layouts.app')

@section('title', 'Import Data Penjualan')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-dark" href="{{ route('sales') }}">
                    <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}"></use>
                    </svg>
                </a>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <h2>Import Data Penjualan</h2>
        
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <form action="{{ route('sales.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="excel_file">Pilih File Excel</label>
                                <input type="file" name="excel_file" id="excel_file" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-dark mt-3">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
