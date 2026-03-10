<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex" id="wrapper">

    {{-- Sidebar --}}
    <div class="bg-dark text-white p-3" style="min-width: 220px; min-height: 100vh;">
        <h4 class="text-center mb-4">My Panel</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="{{ route('purchase.index') }}" class="nav-link text-white">Shop</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-white border-0 bg-transparent">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    {{-- Main Content --}}
    <div class="flex-grow-1">
        <nav class="navbar navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <h5 class="ms-3 mb-0">Shop — Buy Products</h5>
            </div>
        </nav>

        <div class="container my-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Available Products --}}
            <h5 class="mb-3">Available Products</h5>
            <div class="row mb-5">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                {{-- brand_name comes from $appends on Product model --}}
                                <span class="badge bg-dark mb-2">{{ $product->brand_name }}</span>
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="text-muted small">{{ $product->description ?? 'No description.' }}</p>
                                <h6 class="text-success fw-bold">৳ {{ number_format($product->price, 2) }}</h6>

                                @if($product->stock > 0)
                                    <p class="text-muted small mb-3">{{ $product->stock }} in stock</p>
                                    <form action="{{ route('purchase.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                                        <div class="input-group mb-2">
                                            <input type="number" name="quantity" class="form-control form-control-sm"
                                                   value="1" min="1" max="{{ $product->stock }}" placeholder="Qty"/>
                                            <button type="submit" class="btn btn-primary btn-sm">Buy Now</button>
                                        </div>
                                    </form>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No products available.</p>
                    </div>
                @endforelse
            </div>

            {{-- My Purchase History --}}
            <h5 class="mb-3">My Purchase History</h5>
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Brand</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $key => $purchase)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <span class="badge bg-dark">{{ $purchase->product->brand_name }}</span>
                                    </td>
                                    <td>{{ $purchase->product->name }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>৳ {{ number_format($purchase->total_price, 2) }}</td>
                                    <td>
                                        @if($purchase->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($purchase->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $purchase->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No purchases yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
