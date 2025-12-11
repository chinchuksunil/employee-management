<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employee Management')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
        }
        .card {
            border-radius: 12px;
        }
        .role-badge-admin {
            background-color: #dc3545;
        }
        .role-badge-user {
            background-color: #0d6efd;
        }
        .admin-section {
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 15px;
        }
        .user-section {
            border: 2px solid #0d6efd;
            border-radius: 10px;
            padding: 15px;
        }
        .alert-success {
            background-color: #4cb064;
            color: #fff;
            border-color: #139156;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Employee Management</a>

        @auth
        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 text-muted">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
        @endauth
    </div>
</nav>
<div class="bg-white shadow-sm mb-4 p-3 d-flex justify-content-between align-items-center">
    <div class="d-flex gap-3">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
        <a href="{{ route('employees.index') }}" class="btn btn-outline-success btn-sm"> Employees</a>

        @if(auth()->user()->role == 1)
            <a class="btn btn-outline-info btn-sm" href="{{ route('users.index') }}">
                Users
            </a>
        @endif
    </div>

</div>

<main class="py-4">
    <div class="container">

        @if(session('success'))
            <div id="success-alert" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        @yield('content')
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 2000);
    });
</script>

</body>
</html>
