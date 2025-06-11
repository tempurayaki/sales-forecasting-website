@extends('layouts.app')

@section('title', 'Tambah Data Penjualan')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary" href="{{ route('sales') }}">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-left') }}"></use>
                </svg>
            </a>

            <form action="{{ route('sales.store') }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="tanggal" class="form-label">{{ __('Tanggal') }}</label>

                        <input id="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror"
                            name="tanggal" value="{{ old('tanggal') }}">

                        @error('tanggal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="nama_produk" class="form-label">{{ __('Nama Produk') }}</label>

                        <input id="nama_produk" type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                            name="nama_produk" value="{{ old('nama_produk') }}">

                        @error('nama_produk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="subtotal" class="form-label">{{ __('Subtotal') }}</label>

                        <input id="subtotal" type="text" class="form-control @error('subtotal') is-invalid @enderror"
                            name="subtotal" value="{{ old('subtotal') }}">

                        @error('subtotal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto">
                        <label for="kategori" class="form-label">{{ __('Kategori') }}</label>

                        <input id="kategori" type="text" class="form-control @error('kategori') is-invalid @enderror"
                            name="kategori" value="{{ old('kategori') }}">

                        @error('kategori')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9 m-auto text-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <a href="{{ route('sales') }}" class="btn btn-outline-primary">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/efcu5a7iss5i0q7dh7w00t0asixvtd7ks8h6hfhr3ewt9qk8/tinymce/6/tinymce.min.js">
</script>
<script>
    tinymce.init({
            selector: 'textarea.content_information',
            width: 900,
            height: 300
        });
</script>
@endpush