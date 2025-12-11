@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Employees List</h3>
        @if(auth()->user()->role == 1)
            <a href="{{ route('employees.create') }}" class="btn btn-success">
                Add Employee
            </a>
        @endif
    </div>

    <form method="GET" action="{{ route('employees.index') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email or ID" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>



    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Date Of Join</th>
                        @if(auth()->user()->role == 1)
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ 'EMP'.$employee->employee_id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->date_of_birth_formatter }}</td>
                            <td>{{ $employee->date_of_join_formatter }}</td>
                            @if(auth()->user()->role == 1)
                            <td>
                                <a href="{{ route('employees.edit', $employee->emp_id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('employees.destroy', $employee->emp_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role == 1 ? 6 : 5 }}" class="text-center">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

