<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\Product\productCreated;
use App\Events\Product\productUpdated;
use App\Events\Product\productDestroyed;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ValidateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(env('API_PAGINATION', 10));
        return response()->json([
            'success'=> true,
            'message' => 'A list of products',
            'data'=>$products], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\Product\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateProductRequest $request)
    {
        $data = $request->validated();

        $product= Product::create($data);
        
        event(new productCreated($product));

        return response()->json([
            'success'=> true,
            'message'=> 'Product created successfuly',
            'data' => $product,
            ],  201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product= Product::findOrFail($id);
        return response()->json([
            'success'=> true,
            'message'=> 'Á single product retrieved successfully', 
            'data'=> $product
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\Product\UpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated(); 

        $product = Product::findOrFail($id);
        
        $product->update($data);
        
        event(new productUpdated($product));
        return response()->json([
            'success'=> true, 
            'message'=>'Product updated successfuly', 
            'data'=>true
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Product::findOrFail($id);
        $product->delete();

        event(new productDestroyed($product));

        return response()->json([
            'success'=> true, 
            'message'=> 'Product deleted successfuly', 
            'data'=>true
            ], 200);
    }

    /**
     * Search products by author name
     */
    public function searchProductsByAuthorName(Request $request, $author_name)
    {
        $products = Product::where('author_name', $author_name)->paginate(env('API_PAGINATION', 10));
        return response()->json([
            'success'=> true, 
            'message'=> 'Search by author results', 
            'data'=>$products
            ], 200);
    }

    /**
     * Search products by product name
     */
    public function searchProductsByProductName(Request $request, $product_name)
    {
        $products = Product::where('product_name', $product_name)->paginate(env('API_PAGINATION', 10));
        return response()->json([
            'success'=> true, 
            'message'=> 'Search by product name results', 
            'data'=>$products
            ], 200);
    }

    /**
     * Search products by date
     */
    public function searchProductsByDate(Request $request, $date)
    {
        $products = Product::whereDate('created_at', $date)->paginate(env('API_PAGINATION', 10));
        return response()->json([
            'success'=> true, 
            'message'=> 'Search by date results', 
            'data'=>$products
            ], 200);
    }

}
