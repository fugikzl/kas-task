<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService; 
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductService $productService)
    {
        return $this->response($productService->index());
    }

    /**
     * 
     * retrieve all offers of store
     * @param int $id - id of store
     * 
     */
    public function getStoreOffers(int $id, ProductService $productService)
    {
        return $this->response($productService->getStoreOffers($id));
    }

    /**
     * retrieve all offers of product
     * 
     * @param int $id - id of product
     * 
     */
    public function getOffers(int $id, ProductService $productService)
    {
        return $this->response($productService->getOffers($id));
    }

    public function getActiveProducts(ProductService $productService)
    {
        return $this->response($productService->getActiveProducts());
    }


    public function getByCategory(int $id, ProductService $productService)
    {
        return $this->response($productService->getByCategory($id));
    }

    /**
     * Create new product
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, ProductService $productService)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'categoryId' => ['required','numeric'],
            'image' => 'url'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error', $validator->errors(),400);       
        }

        return $this->response($productService->create($request));
    }

    /**
     * Get product by id
     * 
     * @param int $id id of product
     * @return \Illuminate\Http\Response
     */
    public function get(int $id, ProductService $productService)
    {
        return $this->response($productService->get($id));

    }

    public function getProductsByStore(int $id, ProductService $productService)
    {
        return $this->response($productService->getProductsByStore($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductService $productService, int $id)
    {
 
        $validator = Validator::make($request->all(), [
            'categoryId' => ['numeric'],
            'image' => 'url',
            'id' => ['numeric', 'required']
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation error', $validator->errors(),400);       
        }          

        return $this->response($productService->update($id,$request));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        
    }
}
