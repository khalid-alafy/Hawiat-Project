<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use MatanYadaev\EloquentSpatial\Objects\Point;  
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Validation\Rule;


class CompanyController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    // Retrieve all companies
    $companies = Company::all();

    return response()->json($companies);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      // Validate the request data
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

      // Create a new company
      $validatedData['password'] = Hash::make($validatedData['password']);
 
      $latitude = $validatedData['location']['latitude'];
      $longitude = $validatedData['location']['longitude'];
      
      $validatedData['location'] = new Point($latitude, $longitude);
      
      $company = Company::create($validatedData);
 
      return response()->json($company, 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    // Retrieve a specific company
        $company = Company::findOrFail($id);

        return response()->json($company);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Request $request , $id)
  {
   
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    $validatedData = $request->validate([
      'name' => 'required',
      'owner_name' => 'required',
      'email' => 'required|email',
      'commercial_register' => 'required',
      'phone' => 'required|numeric',
      'password' => 'required|min:6',
      'tax_record' => 'required',
      'city' => 'required',
      'location' => 'required',
  ]);
    // Update the company
    $company = Company::find($id);
  
    $validatedData['password'] = Hash::make($validatedData['password']);
 
    $latitude = $validatedData['location']['latitude'];
    $longitude = $validatedData['location']['longitude'];
    
    $validatedData['location'] = new Point($latitude, $longitude);
    return $validatedData['location'];
    $company->update($validatedData);

     return response()->json($company);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $company = Company::findOrFail($id);
    $company->delete();
    return response()->json("deleted successfully");

  }
  
}

?>