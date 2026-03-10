<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Permission</title>
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
                <h5 class="ms-3 mb-0">Create Permission</h5>
            </div>
        </nav>

        <div class="container my-5">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Permission</h4>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Permission Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name') }}"
                                       placeholder="e.g. create-user, edit-post"/>
                                <small class="text-muted">Use lowercase with hyphens.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guard Name</label>
                                <select name="guard_name" class="form-control">
                                    <option value="web" {{ old('guard_name', 'web') == 'web' ? 'selected' : '' }}>web</option>
                                    <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>api</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-end">
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Add Permission</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
