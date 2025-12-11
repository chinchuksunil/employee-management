<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Employee::query();

        if ($search) {
            $search = strtoupper($search);
            $search = str_replace('EMP', '', $search);

            $query->where('employee_id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");

        }

        $employees = $query->orderBy('emp_id', 'desc')->paginate(10);
        return view('employees.index', compact('employees'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastEmployee = Employee::orderBy('emp_id', 'desc')->first();
        $nextNumber = $lastEmployee ? $lastEmployee->employee_id + 1 : 100;
        $displayNextEmployeeId = 'EMP' . $nextNumber;
        return view('employees.create', compact('displayNextEmployeeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:employees,email',
            'date_of_birth' => 'required|date',
            'date_of_join' => 'required|date',
        ]);

        $lastEmployee = Employee::orderBy('emp_id', 'desc')->first();
        $employee_id = $lastEmployee ? $lastEmployee->employee_id + 1 : 100;

        Employee::create([
            'employee_id' => $employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'date_of_join' => $request->date_of_join,
        ]);


        $nextEmployeeId = 'EMP' . ($employee_id + 1);
        return redirect()->route('employees.create')->with('success', 'Employee added successfully!')->with('nextEmployeeId', $nextEmployeeId);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:employees,email,' . $employee->emp_id . ',emp_id',
            'date_of_birth' => 'required|date',
            'date_of_join' => 'required|date',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'date_of_join' => $request->date_of_join,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
