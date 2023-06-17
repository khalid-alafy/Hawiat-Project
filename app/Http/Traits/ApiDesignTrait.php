<?php


namespace App\Http\Traits;

use Illuminate\Http\Response;
trait ApiDesignTrait
{
    public function ApiResponse ($code = 200, $message = null, $errors = null, $data = null) :Response
    {
        $array = [
            'status' => $code,
            'message' => $message,
        ];

        if ( is_null($data) && !is_null($errors) ) {
           $array['errors'] = $errors;
        } elseif ( is_null($errors) && !is_null($data) ) {
            $array['data'] = $data;
         }
         return response($array, 200);
    }
}
