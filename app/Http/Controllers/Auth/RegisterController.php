<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiDesignTrait;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    use ApiDesignTrait;
    /**
     * @OA\Post(
     * path="/api/user/register",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="register new user",
     *    @OA\JsonContent(
     *       required={"name","email","password","phone","location"},
     *     @OA\Property(property="name", type="string", example="user"),
     *     @OA\Property(property="email", type="string", format="email", example="user@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="confirm_password", type="string",example="password12345"),
     *     @OA\Property(property="phone", type="string", example="0551234567"),
     *     @OA\Property(property="image", type="string", example="avater.png"),
     *     @OA\Property(property="location", type="string", example=""),
     *        ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="successfully Operation")
     *     )
     *  ),
     * )
     */
    public function userRegister(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255|string',
            'phone' => 'required|min:10|max:14|string|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
            'email' => 'required|string|email|unique:users',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $latitude = $input['location']['latitude'];
        $longitude = $input['location']['longitude'];
        $input['location'] = new Point($latitude, $longitude);
        $image = $input['image'];
        if (is_null($image)) {
            $defaultImage = "avatar.jpg";
            $input['image'] = $defaultImage;
        }
        $user = User::create($input);
        $success['token'] =  $user->createToken('API_Token',['user'])->plainTextToken;
        $success['name'] =  $user->name;

        return $this->ApiResponse(Response::HTTP_OK, $success['name']. ' registered successfully.',null, $success ['token']);
    }

/*
 * --------------------------------------------company register--------------------------------------------
 *
 * */
    /**
     * @OA\Post(
     * path="/api/company/register",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="register new user",
     *    @OA\JsonContent(
     *       required={"name","owner_name","email","password","phone","city","location","commercial_register","tax_record"},
     *     @OA\Property(property="name", type="string", example="Company_one"),
     *     @OA\Property(property="owner_name", type="string", example="company owner"),
     *     @OA\Property(property="email", type="string", format="email", example="company@company.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="confirm_password", type="string",example="password12345"),
     *     @OA\Property(property="phone", type="string", example="0551234567"),
     *     @OA\Property(property="image", type="string", example="avater.png"),
     *     @OA\Property(property="commercial_register", type="string", example="1234567890"),
     *     @OA\Property(property="tax_record", type="string", example="12345678901"),
     *     @OA\Property(property="city", type="string", example="cairo"),
     *     @OA\Property(property="location", type="string", example=""),
     *        ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="successfully Operation")
     *     )
     *  ),
     * )
     */
    public function companyRegister(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'owner_name' => 'required',
            'email' => 'required|email|unique:companies',
            'commercial_register' => 'required|min:10',
            'phone' => 'required|unique:companies|numeric',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'tax_record' => 'required|min:11',
            'city' => 'required',
            'location' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $validatedData= $request->all();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $latitude = $validatedData['location']['latitude'];
        $longitude = $validatedData['location']['longitude'];
        $validatedData['location'] = new Point($latitude, $longitude);
        $company = Company::create($validatedData);

        $success['token'] =  $company->createToken('API_Token',['company'])->plainTextToken;
        $success['name'] =  $company->name;

        return $this->ApiResponse(Response::HTTP_OK, $success['name']. ' registered successfully.',null, $success ['token']);
    }
}
