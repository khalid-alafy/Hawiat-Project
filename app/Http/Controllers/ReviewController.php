<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;

class ReviewController extends Controller
{   
    use ApiDesignTrait;

    /**
     * Display all reviews.
     */
    public function index()
    {
        try {
            $reviews = Review::all();
            return $this->ApiResponse(Response::HTTP_OK, 'Successful operation', null, $reviews);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NO_CONTENT, null, 'No data provided');
        }
    }

    /**
     * Store new review.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'user_id' => 'required|integer',
            'company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Validation errors', $errors);
        }

        try {
            $review = Review::create($request->all());
            return $this->ApiResponse(Response::HTTP_CREATED, 'Review created successfully', null, $review);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Operation failed', null);
        }
    }

    /**
     * Display a view and send review to edit
     */
    public function show($id)
    {
        try {
            $review = Review::find($id);
            if(!$review)
                return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');

            return $this->ApiResponse(Response::HTTP_OK, 'Review found', null, $review);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');
        }
    }

    /**
     * Update a review.
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'user_id' => 'required|integer',
            'company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Validation errors', $errors);
        }

        try {
            $review = Review::find($id);
            
            if(!$review)
                return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');

            $review->update($request->all());
            return $this->ApiResponse(Response::HTTP_OK, 'Review updated successfully', null, $review);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');
        }
    }

    /**
     * Remove a review.
     */
    public function destroy($id)
    {
        try {
            $review = Review::find($id);

            if(!$review)
                return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');

            $review->delete();
            return $this->ApiResponse(Response::HTTP_OK, 'Review deleted successfully');
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Review not found');
        }
    }
}
