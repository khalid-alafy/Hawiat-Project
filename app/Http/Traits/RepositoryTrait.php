<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait RepositoryTrait
{ use ApiDesignTrait;

    public function login($request,$guard)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard($guard)->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::guard($guard)->user();
            $success['token'] = $user->createToken('API_Token',[$guard])->plainTextToken;
            $success['name'] = $user->name;
            return $this->ApiResponse(200, ' welcome: ' . $success['name'], null, $success ['token']);
        } else {
            return $this->ApiResponse(422, 'Unauthorised.', ['error' => 'Bad Credentials']);
        }
    }
}
