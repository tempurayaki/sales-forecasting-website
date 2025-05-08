@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-right mb-4">
        <div>
            <a href="{{ route('sales.add') }}" class="btn btn-success text-light ml-1">
                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                Tambah Data
            </a>            
        </div>
        <div class="mx-3">
            <a href="{{ route('sales.upload') }}" class="btn btn-dark text-light ml-1">
                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-data-transfer-up') }}"></use>
                </svg>
                Import Data
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
                        <div class="font-weight-bold h5">Data</div>
                    </div>
                    {{-- <div>
                        <a class="btn btn-link">
                            <i class="fas fa-sort mr-2"></i> Urutkan
                        </a>
                    </div> --}}
                </div>
                <div class="card-body p-0 overflow-auto">
                    <table class="table table-striped table-fixed">
                        <thead>
                            <tr class="sticky-top">
                                <th class="text-center w-15">{{ __('No') }}</th>
                                <th class="text-center w-25">{{ __('Tanggal') }}</th>
                                <th class="text-center w-25">{{ __('Nama Produk') }}</th>
                                <th class="text-center w-25">{{ __('Subtotal') }}</th>
                                <th class="text-center w-25">{{ __('Kategori') }}</th>
                                <th class="text-center w-25">{{ __('#') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = $rows instanceof \Illuminate\Pagination\LengthAwarePaginator ? $rows->firstItem() : 0)
                        
                            @foreach ($rows as $key => $item)
                                <tr class="data-tables" data-id="{{ $item->id }}">
                                    <td class="text-center">{{ ($rows->currentPage() - 1) * $rows->perPage() + ($key + 1) }}</td>
                                    <td class="text-center">{{ $item->tanggal }}</td>
                                    <td class="text-center">{{ $item->nama_produk }}</td>
                                    <td class="text-center">{{ $item->subtotal }}</td>
                                    <td class="text-center">{{ $item->kategori }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('sales.edit', $item->id) }}" class="btn btn-sm text-warning">
                                                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                                                </svg>
                                            </a>
                                            <a href="#" class="btn btn-sm text-danger" 
                                            onclick="event.preventDefault(); document.getElementById('deleteRow{{ $item->id }}').submit();">
                                                <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
                                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                                                </svg>
                                            </a>
                                            <form id="deleteRow{{ $item->id }}" action="{{ route('sales.delete', $item->id) }}" 
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
                    @if(isset($rows) && count($rows) === 0)
                        <div class="h-300">
                            <div class="text-center">
                                <div>Data tidak ditemukan</div>
                            </div>
                        </div>
                    @endif
                </div>

                @include('partials.card-footer')
            </div>
        </div>
    </div>
</div>
@endsection
