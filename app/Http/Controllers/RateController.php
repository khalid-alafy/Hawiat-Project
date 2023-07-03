<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{
    use ApiDesignTrait;
    /**
     * Display rates.
     */
    public function index()
    {
         try {
            $rates = Rate::all();
            return $this->ApiResponse(Response::HTTP_OK, 'Successful operation', null, $rates);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NO_CONTENT, null, 'No data provided');
        }
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
        $validator = Validator::make($request->all(), [
            'rate' => 'required',
            'user_id' => 'required|integer',
            'company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Validation errors', $errors);
        }

        try {
            $rate = Rate::create($request->all());
            return $this->ApiResponse(Response::HTTP_CREATED, 'rate created successfully', null, $rate);
        } catch (\Exception $e) {
            return $this->ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to create rate');
        }
    }

    /**
     * Display a company rate and send review to edit.
     */
    public function show($id)
    {
        $rate = Rate::find($id);

        if (!$rate) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Rate not found');
        }

        return $this->ApiResponse(Response::HTTP_OK, 'Rate found', null, $rate);
    }

    /**
     * Update company rate.
     */
    public function update(Request $request,$id)
    {
        $rate = Rate::find($id);

        if (!$rate) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');
        }

        $validator = Validator::make($request->all(), [
            'rate' => 'required',
            'user_id' => 'required|integer',
            'company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Validation errors', $errors);
        }

        try {
            $rate->update($request->all());
            return $this->ApiResponse(Response::HTTP_OK, 'Rate updated successfully');
        } catch (\Exception $e) {
            return $this->ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to update rate');
        }
    }

    /**
     * Remove company rate.
     */
    public function destroy($id)
    {
        $rate = Rate::find($id);

        if (!$rate) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Rate not found');
        }

        try {
            $rate->delete();
            return $this->ApiResponse(Response::HTTP_OK, 'Rate deleted successfully');
        } catch (\Exception $e) {
            return $this->ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to delete rate');
        }
    }
}
