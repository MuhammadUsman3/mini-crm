<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Retrieve all employees from the database
        $employees = Employee::all();

        if ($request->expectsJson()) {
            // If the request expects JSON, return a JSON response
            return response()->json(EmployeeResource::collection($employees));
        } else {
            // If not, return the HTML view with employees data
            return view('employees.index', compact('employees'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retrieve a list of companies with 'name' and 'id' fields
        $companies = Company::select(['name', 'id'])->get();

        // Load the 'employees.create' view and pass the 'companies' variable to it
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        // Create a new Employee instance
        $employee = new Employee();

        // Set the properties of the Employee from the request data
        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->email = $request->input('email');
        $employee->company_id = $request->input('company_id');
        $employee->phone = $request->input('phone');

        // Save the new Employee to the database
        $employee->save();

        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Employee created successfully', 'Employee' => EmployeeResource::make($employee)], 201);
        } else {
            // Redirect to the 'employees.index' route after successful creation
            return redirect()->route('employees.index');
        }
    }

    /**
     * Display the details of a specific employee.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee,Request $request)
    {
        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(EmployeeResource::make($employee));
        } else {
            // Load the 'employees.show' view and pass the 'employee' variable to it
            return view('employees.show', compact('employee'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        // Retrieve a list of companies with 'name' and 'id' fields
        $companies = Company::select(['name', 'id'])->get();

        // Check if the employee exists
        if (!$employee) {
            // Redirect to a 404 page or display an error message
            return abort(404);
        }

        // Load the 'employees.edit' view and pass the 'companies' and 'employee' variables using compact
        return view('employees.edit', compact('companies', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        // Update the Employee model with values from the request
        $employee->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'company_id' => $request->input('company_id'),
            'phone' => $request->input('phone'),
        ]);

        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Employee updated successfully', 'Employee' => EmployeeResource::make($employee)], 201);
        } else {
            // Redirect to the 'employees.index' route after successful update
            return redirect()->route('employees.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // Delete the employee from the database
        $employee->delete();

        // Redirect to the 'employees.index' route with a success message
        return redirect()->route('employees.index')->withSuccess(__('Employee deleted successfully.'));
    }
}
