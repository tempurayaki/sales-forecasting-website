@extends('layouts.app')

@section('title', 'Forecast Penjualan')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('sales.forecast') }}">
            <select name="category" onchange="this.form.submit()">
                <option value="all">All Products</option>
                <option value="category1" {{ request('category') == 'category1' ? 'selected' : '' }}>Category 1</option>
                <option value="category2" {{ request('category') == 'category2' ? 'selected' : '' }}>Category 2</option>
                <!-- Add more categories as needed -->
            </select>
        </form>

        {{-- <h2>Sales Forecast</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Sales</th>
                    <th>Forecast</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesData as $data)
                    <tr>
                        <td>{{ $data->date }}</td>
                        <td>{{ number_format($data->total_sales, 2) }}</td>
                        <td>
                            @if (isset($forecastData[$loop->index]))
                                {{ number_format($forecastData[$loop->index]['forecast'], 2) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
@endsection
