<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex" id="wrapper">

    {{-- Sidebar --}}
    <div class="bg-dark text-white p-3" style="min-width: 220px; min-height: 100vh;">
        <h4 class="text-center mb-4">Dashboard</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="/dashboard" class="nav-link text-white">Dashboard</a></li>
            <li><a href="{{ route('product') }}" class="nav-link text-white">Product</a></li>
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
                <h5 class="ms-3 mb-0">Permission List</h5>
                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm me-3">+ Add Permission</a>
            </div>
        </nav>

        <div class="container my-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Guard</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $key => $permission)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $permission->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $permission->guard_name }}</span>
                                    </td>
                                    <td>{{ $permission->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('permissions.edit', $permission->id) }}"
                                           class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('permissions.destroy', $permission->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No permissions found.</td>
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
