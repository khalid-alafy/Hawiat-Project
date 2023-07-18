<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    use ApiDesignTrait;
    protected static string $currency = 'EGP' ;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('payment')->get();
        if ($orders) {
            return $this->ApiResponse(200, 'All Orders with their products', null, $orders);
        }
        return $this->ApiResponse(205, null, 'No Orders Found');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
    //    At this point it must to check authentication
          $validator = Validator::make($request->all(),[
            'tenancy' => ['required', Rule::in(['contract', 'temporary'])],
            'status' => ['required', Rule::in(['successful', 'failed','pending'])],
            'total_price'=> 'required|numeric',
            'quantity' => 'required|numeric',
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $input =$request->all();
            $input['currency'] = self::$currency;
            $order = Order::create($input);
        } catch (Exception $e) {
            return $this->ApiResponse(422, 'operation failed');
        }
        $payPage = new PaymentController();
        return $payPage->initiatePayment($order); 
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order =  Order::with('payment')->find($id);
        if ($order) {
            return $this->ApiResponse(200, 'Successfully operation', null, $order);
        }
        return $this->ApiResponse(205, 'Order not found');
    }

    /**
     * Delete Order
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $delete = Order::destroy($id);
        if ($delete) {
            return $this->ApiResponse(200, 'Order deleted successfully');
        }
        return $this->ApiResponse(205, "Unable to delete the Order, It may be doesn't exist",);
    }
}
