<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex" id="wrapper">

    {{-- Sidebar --}}
    <div class="bg-dark text-white p-3" style="min-width: 220px; min-height: 100vh;">
        <h4 class="text-center mb-4">Dashboard</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="/dashboard" class="nav-link text-white">Dashboard</a></li>
            <li><a href="{{ route('products.index') }}" class="nav-link text-white">Product</a></li>
            <li><a href="{{ route('brands.index') }}" class="nav-link text-white">Brand</a></li>
            <li><a href="{{ route('users.index') }}" class="nav-link text-white">User</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="roleDropdown" role="button"
                   data-bs-toggle="dropdown">Role & Permission</a>
                <ul class="dropdown-menu" aria-labelledby="roleDropdown">
                    <li><a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a></li>
                    <li><a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a></li>
                </ul>
            </li>
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
                <h5 class="ms-3 mb-0">Brand List</h5>
                <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm me-3">+ Add Brand</a>
            </div>
        </nav>

        <div class="container my-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Brand Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $key => $brand)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $brand->name }}</strong></td>
                                    <td><code>{{ $brand->slug }}</code></td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $brand->products_count }} Products</span>
                                    </td>
                                    <td>
                                        @if($brand->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('brands.edit', $brand->id) }}"
                                           class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('brands.destroy', $brand->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure? All products under this brand will be deleted.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No brands found.</td>
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
