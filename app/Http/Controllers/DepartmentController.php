<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    use ApiDesignTrait;

    /**
     * Display a listing of the Department with their products.
     */
    public function index()
    {
        $departments = Department::all();
        if ($departments) {
            return $this->ApiResponse(200, 'All Departments', null, $departments);
        }
        return $this->ApiResponse(205, null, 'No Department Found', null);
    }

    /**
     * Display a listing of the Department with their products.
     */
    public function departmentProducts()
    {
        $departments = Department::with('products')->get();
        if ($departments) {
            return $this->ApiResponse(200, 'All Departments with their products', null, $departments);
        }
        return $this->ApiResponse(205, null, 'No Departments Found', null);
    }

    /**
     * Display a listing of the Department with their Branches.
     */
    public function departmentBranches()
    {
        $departments = Department::with('branches')->get();
        if ($departments) {
            return $this->ApiResponse(200, 'All Departments with their Branches', null, $departments);
        }
        return $this->ApiResponse(205, null, 'No Departments Found', null);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //make sure that admin only can insert
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255|string',
            'tenancy_type' => 'required',Rule::in(['0', '1', '2']),
            'parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ApiResponse(422, 'Validation Error',$validator->errors());
        }

        $input = $request->all();
        $department = Department::create($input);
        if ($department) {
            return $this->ApiResponse(200, 'Successfully operation', null, $department);
        }
        return $this->ApiResponse(400, 'Operation failed');
    }

    /**
     * Display the specified Department with its products.
     */
    public function show(string $id)
    {
        $department= Department::with('products')->find($id);
        if ($department) {
            return $this->ApiResponse(200, 'Successfully operation', null, $department);
        }
        return $this->ApiResponse(205, 'Department not found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255|string',
            'tenancy_type' => 'required',Rule::in(['0', '1', '2']),
            'parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ApiResponse(422, 'Validation Error',$validator->errors());
        }

        $department = Department::find($id);
        if ($department) {
            $input = $request->all();
            $updateDepartment = $department->update($input);
            if ($updateDepartment) {
                return $this->ApiResponse(200, 'Department updated successfully');
            }
            return $this->ApiResponse(205, 'Unable to update the Department');
        }
        return $this->ApiResponse(205,'Unable to find the specified Department  ');
    }

    /**
     * Remove the specified Department from storage.
     */
    public function destroy(string $id)
    {
        $delete = Department::destroy($id);
        if ($delete) {
            return $this->ApiResponse(200, 'Department deleted successfully');
        }
        return $this->ApiResponse(205, "Unable to delete the specified Department , It may be doesn't exist",);
    }
}
