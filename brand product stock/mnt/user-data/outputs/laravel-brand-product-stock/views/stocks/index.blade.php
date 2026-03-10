@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Stock</h2>
        <a href="{{ route('stocks.create') }}" class="btn btn-primary">+ Add Stock</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Brand</th>
                <th>Product</th>
                <th>Serial Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $stock)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stock->product->brand->name }}</td>
                <td>{{ $stock->product->name }}</td>
                <td><code>{{ $stock->serial_number }}</code></td>
                <td>
                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this stock entry?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No stock entries found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
