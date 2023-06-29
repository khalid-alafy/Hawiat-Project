<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use MatanYadaev\EloquentSpatial\Objects\Point;

//use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ApiDesignTrait;


    /**
     * @OA\Post(
     * path="/api/login",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
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

    public function login(Request $request)
    {
        $data = $request->all();
        return $this->auth('user', $data);
    }


//        *      security={ {"sanctum": {} }},

    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="index",
     *      tags={"User"},
     *      summary="Get list of Users",
     *      description="Returns list of User  Data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="users", type="object", ref="#/components/schemas/User"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     *     )
     */
    public function index(): Response
    {
//        $user = auth('sanctum')->user(); // Authentication && authorization check
        try {
            $users = User::all();
            return $this->ApiResponse(Response::HTTP_OK, 'Successful operation', Null, $users);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NO_CONTENT, null, 'No data provided');
        }
    }

    /**
     * @OA\Post(
     * path="/api/users",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store new user",
     *    @OA\JsonContent(
     *       required={"name","email","password","phone","location"},
     *     @OA\Property(property="name", type="string", example="user"),
     *     @OA\Property(property="email", type="string", format="email", example="user@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="phone", type="string", example="0551234567"),
     *     @OA\Property(property="image", type="string", example="avater.png"),
     *     @OA\Property(property="location", type="string", example=""),
     *        ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="User created")
     *     )
     *  ),
     * )
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|max:255|string',
            'phone' => 'required|min:10|max:14|string|unique:users',
            'password' => 'required|string|min:6',
            'location' => 'required',
            'image' => '',
            'email' => 'required|string|email|unique:users',
        ]);

        try {
            $validator['password'] = Hash::make('password');
            $latitude = $validator['location']['latitude'];
            $longitude = $validator['location']['longitude'];
            $validator['location'] = new Point($latitude, $longitude);
            $validator['image'] = $this->imageCheck($validator['image']);
            User::create($validator);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'operation failed', null);
        }
        return $this->ApiResponse(Response::HTTP_OK, 'User Created Successfully', null);
    }

    /**
     * @param $imageValidator
     * @return string
     * helper method
     */
    private function imageCheck($imageValidator)
    {
        $image = $imageValidator;
        if (is_null($image)) {
            $defaultImage = "avatar.jpg";
            return $defaultImage;
        } else {
            return $image;
        }
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      tags={"User"},
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

    public function show(string $id): Response
    {
        try {
            $user = User::find($id);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, null, 'can not Find User Data');
        }
        return $this->ApiResponse(Response::HTTP_OK, null, null, $user);
    }

    /**
     * @OA\Put (
     * path="/api/users/{id}",
     * tags={"User"},
     *     @OA\Parameter(
     *          name="id",
     *          description="user id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="update new user",
     *    @OA\JsonContent(
     *       required={"name","email","password","phone"},
     *     @OA\Property(property="name", type="string", example="user"),
     *     @OA\Property(property="email", type="string", format="email", example="user@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="phone", type="string", example="0551234567"),
     *     @OA\Property(property="image", type="string", example="avater.png"),
     *          @OA\Property(property="location", type="array",
     *          @OA\Items(
     *                   @OA\Property(property="latitude", type="string",example ="40.712776"),
     *                  @OA\Property(property="longitude", type="string",example ="-74.005974")
     *              ),
     *           ),
     *     ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="operation success")
     *     )
     *  ),
     * )
     */


    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'name' => 'required|max:255|string',
            'phone' => 'required|min:10|max:14|string',
            'password' => 'required|string|min:6',
            'location' => 'required',
            'image' => '',
            'email' => 'required|string|email',
        ]);
        try {
            $validator['password'] = Hash::make('password');
            $latitude = $validator['location']['latitude'];
            $longitude = $validator['location']['longitude'];
            $validator['location'] = new Point($latitude, $longitude);
            $validator['image'] = $this->imageCheck($validator['image']);
            $user = User::find($id);
            $user->update($validator);

        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, null, ' something error try again later');
        }
        return $this->ApiResponse(Response::HTTP_OK, 'successfully operation', null, $user);
    }

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      tags={"User"},
     *      description="Deletes a User and returns no Message",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example="successfully operation")
     *           )
     * )
     * )
     */

    public function destroy(string $id): Response
    {
        /*
         * $user = User::find($id);
         * $user->delete();
        */
//        try{
        user::destroy($id);
//        } catch (Exception $e) {
//            return $this->ApiResponse(Response::HTTP_BAD_REQUEST,null,' something error try again later');
//        }
        return $this->ApiResponse(Response::HTTP_MOVED_PERMANENTLY, 'Account deleted successfully');
    }
}
