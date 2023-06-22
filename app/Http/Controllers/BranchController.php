<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Support\Facades\Validator;
class BranchController extends Controller
{

    use ApiDesignTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Branches = Branch::with('products')->get();
        if ($Branches) {
            return $this->ApiResponse(200, 'All Branches with their products', null, $Branches);
        }
        return $this->ApiResponse(205, null, 'No branch Found', null);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * Store a newly created resource in storage.
     */
    public function store(Request $request)  : Response
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255|string',
            'location' => 'required',
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ApiResponse(422, 'Operation failed',$validator->errors());
        }

        $input = $request->all();
        $latitude = $input['location']['latitude'];
        $longitude = $input['location']['longitude'];
        $input['location'] = new Point($latitude, $longitude);
        $branch = Branch::create($input);
        if ($branch) {
            $branch->departments()->Sync($request->departments);
            return $this->ApiResponse(200, 'Successfully operation', null, $branch);
        }
        return $this->ApiResponse(400, 'Operation failed');
    }
    /**
     * @param string $id
     * @return \Illuminate\Http\Response
     * Display the specified resource.
     */
    public function show(string $id) : Response
    {
        $branch= Branch::with('products')->find($id);
        if ($branch) {
            return $this->ApiResponse(200, 'Successfully operation', null, $branch);
        }
        return $this->ApiResponse(205, 'Branch not found');
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\Response
     * Display the Branch for specified company.
     */
/*    public function displayCompanyBranches(string $id) : Response
    {
        $branch= Company::with('branches')->find($id);
        if ($branch) {
            return $this->ApiResponse(200, 'Successfully operation', null, $branch);
        }
        return $this->ApiResponse(205, 'Company not found');
    }*/

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
            'location' => 'required',
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $branch = Branch::find($id);
        if ($branch) {
            $branch->departments()->sync($request->departments);
            $input = $request->all();
            $latitude = $input['location']['latitude'];
            $longitude = $input['location']['longitude'];
            $input['location'] = new Point($latitude, $longitude);
            $updateBranch = $branch->update($input);
            if ($updateBranch) {
                return $this->ApiResponse(200, 'Branch updated successfully',$updateBranch);
            }
            return $this->ApiResponse(205, 'Unable to update the Branch');
        }
        return $this->ApiResponse(205,'Unable to find the Branch ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Branch::destroy($id);
        if ($delete) {
            return $this->ApiResponse(200, 'Branch deleted successfully');
        }
        return $this->ApiResponse(205, "Unable to delete the branch, It may be doesn't exist",);
    }
}
