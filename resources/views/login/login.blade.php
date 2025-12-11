<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Employee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        .role-btns button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Employee Management</a>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>{{ ($role === 'admin') ? 'Admin Login' : 'User Login' }}</span>

                            <div class="role-btns">
                                @if($role === 'user')
                                    <a href="{{ url('login/admin') }}"
                                    class={{ $role === 'admin' ? 'btn-danger' : 'btn-outline-danger' }}">
                                        Admin Login
                                    </a>
                                @endif
                                @if($role === 'admin')

                                    <a href="{{ url('login') }}"
                                    class=" {{ $role === 'user' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        User Login
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('login.submit') }}">
                                @csrf
                                <input type="hidden" name="role" id="role" value="{{ $role ?? 'user' }}">

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                    </div>
                                </div>

                                @if($role === 'user')
                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                                <label class="form-check-label" for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                </div>
                            </form>


                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class=" mb-3">Demo Login Credentials</h6>
                                    <div class="row">
                                        @if($role === 'admin')
                                            <div class="col-md-6">
                                                <div class="card border-danger">
                                                    <div class="card-body">
                                                        <span class="badge bg-danger mb-2">ADMIN</span>
                                                        <p class="mb-1"><strong>Email:</strong> chinchu@gmail.com</p>
                                                        <p class="mb-0"><strong>Password:</strong> Alice@123</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($role === 'user')
                                            <div class="col-md-6">
                                                <div class="card border-primary">
                                                    <div class="card-body ">
                                                        <span class="badge bg-primary mb-2">USER</span>
                                                        <p class="mb-1"><strong>Email:</strong> john@example.com</p>
                                                        <p class="mb-0"><strong>Password:</strong> password123</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
