<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Company; 
use App\Models\Branch; 
use MatanYadaev\EloquentSpatial\Objects\Point;


class ProductController extends Controller
{
    use ApiDesignTrait;
    /**
     * Display all products.
     */
    public function index()
    {
        
        $products = Product::all();
        return $this->ApiResponse(Response::HTTP_OK, 'show products', null, $products);
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'nullable',
            'contract_price' => 'nullable|numeric|min:0|max:9999.99',
            'temporary_price' => 'nullable|numeric|min:0|max:9999.99',
            'volume' => 'required',
            'description' => 'nullable',
            'branch_id' => 'required|integer|exists:branches,id',
            'department_id' => 'required|integer|exists:departments,id',
        ]);

        //handle validation errors
        if ($validator->fails()) {

            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'validation errors', $errors);   
        }

        try {
            Product::create($request->all());
            
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'operation failed', null);
        }
        return $this->ApiResponse(Response::HTTP_OK, 'Product Created Successfully', null);
    }
/**
     * Store Branch Products.
     */
    public function insertBranchProducts(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'products.*.name' => 'required',
            'products.*.image' => 'nullable',
            'products.*.contract_price' => 'nullable|numeric|min:0|max:9999.99',
            'products.*.temporary_price' => 'nullable|numeric|min:0|max:9999.99',
            'products.*.volume' => 'required',
            'products.*.description' => 'nullable',
            'products.*.branch_id' => 'required|integer|exists:branches,id',
            'products.*.department_id' => 'required|integer|exists:departments,id',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Validation errors', $errors);
        }

        try {
            $productsData = $request->input('products');
            $products = [];

            foreach($productsData as $productData) {
                $product = Product::create($productData);
                $products[] = $product;
            }

            return $this->ApiResponse(Response::HTTP_OK, 'Products Created Successfully',null,$products);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Operation failed', null);
        }

        
    }

    /**
     * return nearest branches productes.
     */
    public function nearestBranchesProducts(Request $request)
    {
        $userLatitude = $request['location']['latitude'];
        $userLongitude = $request['location']['longitude']; 
        $userLocation = new Point($userLatitude, $userLongitude);
        try {
                $nearestBranches = Branch::query()
                                ->orderByDistance('location', $userLocation)
                                ->with('products')
                                ->limit(3)
                                ->get();
                return $this->ApiResponse(Response::HTTP_OK, 'Nearest Branches Products ',null,$nearestBranches);
            }catch (Exception $e) {
                return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Operation failed', null);
        }
        
    }

    
    /**
     * Search for a product
     */
    public function searchProduct(Request $request)
    {
        $searchTerm = $request->searchTerm; 

        $userLatitude = $request['userLocation']['latitude'];
        $userLongitude = $request['userLocation']['longitude'];

        $userLocation = new Point($userLatitude, $userLongitude);
        try {
                //return nearest branches products based on user location,search in name and description fields, limited result 
                $nearestProductsSearch = Branch::query()
                ->orderByDistance('location', $userLocation)
                ->with(['products' => function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('description', 'LIKE', '%'.$searchTerm.'%');
                }])
                ->limit(4)
                ->get();

                return $this->ApiResponse(Response::HTTP_OK, 'Nearest Branches Products ',null,$nearestProductsSearch);
        }catch (Exception $e) {
                return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Operation failed', null);
        }
    }
    /**
     * Display a company products.
     */
    public function companyProducts($companyId)
    {
        try
        {
            $company = Company::with('branches.products')->find($companyId);
            $products = $company->branches->flatMap(function ($branch) {
                return $branch->products;
            });
        
            return $this->ApiResponse(Response::HTTP_OK, 'Company Products',null, $products);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'Operation failed', null);
        }
       
    }

    /**
     * Display a product data and send to edit product.
     */
    public function show(string $productId)
    {
        $product = Product::find($productId);

        if ($product) {
            return $this->ApiResponse(Response::HTTP_OK,"Product",null,$product);
        }
        else {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST,'Product not found!',null);
        }
    }

    /**
     * Update a product.
     */
    public function update(Request $request, string $productId)
    {
        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'nullable',
            'contract_price' => 'nullable|numeric|min:0|max:9999.99',
            'temporary_price' => 'nullable|numeric|min:0|max:9999.99',
            'volume' => 'required',
            'description' => 'nullable',
            'branch_id' => 'required|integer',
            'department_id' => 'required|integer',
        ]);

        //handle validation errors
        if ($validator->fails()) {

            $errors = $validator->errors();
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'validation errors', $errors);   
        }

        try {   
            $product = Product::find($productId); // Retrieve the product based on the ID

            $product->update($request->all()); // Update the product using the request data
            
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, 'operation failed', null);
        }
        return $this->ApiResponse(Response::HTTP_OK, 'Product Updated Successfully',null, $product);
    }

    /**
     * Remove a product.
     */
    public function destroy(string $productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->delete();
            return $this->ApiResponse(Response::HTTP_OK,"Product deleted successfully",null);
        }
        else {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST,'Product not found!',null);
        }
    }
}
