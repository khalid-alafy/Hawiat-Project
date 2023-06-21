<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Complaint;
use App\Models\Department;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Support\Facades\Auth;


class AuthCompanyController extends Controller
{
    use ApiDesignTrait;

    public function login(Request $request){
        
        $company = $request->validate([
            'phone' => 'required|numeric',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('phone', 'password');

        $company = Company::where('phone', $credentials['phone'])->first();

        if ($company && Hash::check($credentials['password'], $company->password)) {
            $token = $company->createToken('API Token')->plainTextToken;

            return response()->json(['access_token' => $token], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
        
    }

    public function register(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'owner_name' => 'required',
            'email' => 'required|email|unique:companies',
            'commercial_register' => 'required',
            'phone' => 'required|unique:companies|numeric',
            'password' => 'required|min:6',
            'tax_record' => 'required',
            'city' => 'required',
            'location' => 'required',
        ]);
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $latitude = $validatedData['location']['latitude'];
        $longitude = $validatedData['location']['longitude'];
        
        $validatedData['location'] = new Point($latitude, $longitude);
        
        $company = Company::create($validatedData);
        
        $token = $company->createToken('API Token')->plainTextToken;
    
        return response()->json(['access_token' => $token], 201);
    }

    public function logout(){
        return response()->json('this is my logout method');
    }
 
    public function test(){
        // $company = Company::with('branches')->find(3);
        // return response()->json($company);
        $branch = Branch::with('departments','products')->find(1);
        return response()->json($branch->products);

    }
}
