@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- Welcome Card --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">Welcome, {{ auth()->user()->name }} 👋</h4>
                {{-- <small class="text-muted"></small> --}}
            </div>
            <span class="badge {{ auth()->user()->role == 1 ? 'role-badge-admin' : 'role-badge-user' }}">
                {{ auth()->user()->role == 1 ? 'Admin' : 'User' }}
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Employees</h6>
                    <h3>{{ $totalEmployees }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Employees Created This Month</h6>
                    <h3>{{ $thisMonthEmployees }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Employees Joined This Month</h6>
                    <h3>{{ $thisMonthJoinEmployees }}</h3>
                </div>
            </div>
        </div>


    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">Latest 5 Employees</div>
        <div class="card-body p-0">
            <table class="table mb-0 table-striped">
                <thead class="table-light">
                     <tr>
                        <th>#</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Date of Joining</th>
                    </tr>

                </thead>
                <tbody>
                    @forelse($recentEmployees as $emp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ 'EMP'.$emp->employee_id }}</td>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->email }}</td>
                            <td>{{ $emp->date_of_birth_formatter }}</td>
                            <td>{{ $emp->date_of_join_formatter }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No employees found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Admin Controls --}}
    @if(auth()->user()->role == 1)
        <div class="admin-section mb-4 bg-white shadow-sm p-3" style="display:none">
            <h5 class="text-danger mb-3">Admin Controls ⚡</h5>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('employees.create') }}" class="btn btn-success btn-sm">➕ Add Employee</a>
                <a href="{{ route('employees.index') }}" class="btn btn-primary btn-sm">📋 Manage Employees</a>
                <button class="btn btn-secondary btn-sm" disabled>📊 Reports</button>
                <button class="btn btn-secondary btn-sm" disabled>⚙️ Settings</button>
            </div>
            <div class="alert alert-danger mb-0">You have full CRUD access to the system ✔️</div>
        </div>
    @endif

    {{-- User Access --}}
    @if(auth()->user()->role == 0)
        <div class="user-section bg-white shadow-sm p-3" style="display:none">
            <h5 class="text-primary mb-3">User Access ℹ️</h5>
            <div class="alert alert-info">You have read-only access to employee data.</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('employees.index') }}" class="btn btn-outline-primary btn-sm">👀 View Employees</a>
                <button class="btn btn-outline-secondary btn-sm" disabled>🔍 Search</button>
            </div>
            <div class="alert alert-primary mb-0">You have limited access in this system.</div>
        </div>
    @endif

</div>

@endsection
