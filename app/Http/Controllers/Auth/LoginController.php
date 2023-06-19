<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\RepositoryTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends  Controller
{
    use ApiDesignTrait,RepositoryTrait;


    /**
     * @OA\Post(
     * path="/api/user/login",
     * description="Login User and Create token",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store User data",
     *    @OA\JsonContent(
     *       required={"phone","password"},
     *     @OA\Property(property="phone", type="string", example="0551234567"),
     *     @OA\Property(property="password", type="password", example="password12345"),
     *        )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="User", type="object", ref="#/components/schemas/User"),
     *     ),
     * )
     */

    public function userLogin(Request $request)
    {
        $guard = 'user';
        return $this->login($request,$guard);
    }
    /**
     * @OA\Post(
     * path="/api/company/login",
     * description="Login Company and Create token",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store Company data",
     *    @OA\JsonContent(
     *       required={"phone","password"},
     *     @OA\Property(property="phone", type="string", example="0551234567"),
     *     @OA\Property(property="password", type="password", example="password12345"),
     *        )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="User", type="object", ref="#/components/schemas/User"),
     *     ),
     * )
     */

    public function companyLogin(Request $request)
    {
        $guard = 'company';
        return $this->login($request,$guard);
    }

    public function logout()
    {
        $admin = auth('sanctum')->user();
        $admin->tokens()->where('id', $admin->currentAccessToken()->id)->delete();
        return $this->ApiResponse(Response::HTTP_OK, 'user logged out successfully', null);
    }
}
