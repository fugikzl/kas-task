<?php
namespace App\Services;
use App\Models\Product;
use Illuminate\Http\Request;
use App\ApiResponse\Response;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Creates Product from request
     * 
     * @param Request $request
     * @return \App\ApiResponse\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $product = Product::create($input);
        $response = new Response(false);
        $response = $response->makeSuccessResponse($product, "Prodcut created successfuly");
        return $response;
    }

    /**
     * returns all products of this store
     * 
     * @param int $storeId id of store
     * @return \App\ApiResponse\Response
     */
    public function getProductsByStore(int $storeId)
    {
        $products =  Product::where("storeId", $storeId)->get();
        $response = new Response(false);
        $response = $response->makeSuccessResponse($products, "Prodcuts of store retrieved successfuly");
        return $response;
    }

    /**
     * get All products
     * @return \App\ApiResponse\Response
     */
    public function index()
    {
        $products = Product::all();
        $response = new Response(false);
        $response = $response->makeSuccessResponse($products, "Prodcuts retrieved successfuly");
        return $response;   
    }

    public function getActiveProducts()
    {
        // $products = Product::all();
        $products = DB::table("products")->
            join("store_products","store_products.productId","=","products.id")->
            where("store_products.productId","!=",null)->
            select(["products.id as id", "products.name","products.image","products.categoryId"])->
            distinct()->
            get();

        $response = new Response(false);
        $response = $response->makeSuccessResponse($products, "Active products retrieved successfuly");
        return $response;
    }

    /**
     * get All products
     * @return \App\ApiResponse\Response
     */
    public function update(int $id, Request $request)
    {
        $input = $request->all();
        $num = Product::where("id",$id)->update($input);
        if($num){
            $response = new Response(false);
            $response = $response->makeSuccessResponse(["updatedRows" => $num], "Prodcuts updated successfuly");
            return $response;
            
        }else{
            $response = new Response(true);
            $response = $response->makeErrorResponse("Rows did not affected", [], 404);
            return $response;
        }
    }

    /**
     * 
     * @param int $id id of product
     * @return \App\ApiResponse\Response
     */
    public function get(int $id)
    {
        $product = Product::where("id",$id)->get()->first();
        $response = new Response(false);
        $response = $response->makeSuccessResponse($product, "Prodcut retrieved successfuly");
        return $response;
    }

    public function getStoreOffers(int $id)
    {
        $offers = DB::table("store_products")->
            leftJoin("products","store_products.productId","=","products.id")->
            where("store_products.storeId","=",$id)->
            select("products.id","products.categoryId","store_products.price","products.name","products.image","store_products.storeId")->
            get();
        $response = new Response(false);
        $response = $response->makeSuccessResponse($offers, "Offers of store retrieved successfuly");
        return $response;
    }

    public function getOffers(int $id)
    {
        $offers = DB::table("store_products")->
            leftJoin("products","store_products.productId","=","products.id")->
            leftJoin("stores","store_products.storeId", "=","stores.id")->
            where("store_products.productId","=",$id)->
            select("stores.name","store_products.price","store_products.storeId")->
            get();
        $response = new Response(false);
        $response = $response->makeSuccessResponse($offers, "Offers of store retrieved successfuly");
        return $response;
    }

    public function getByCategory(int $id)
    {
        $products = DB::table("products")->
            join("store_products","store_products.productId","=","products.id")->
            where("store_products.productId","!=",null,"and")->
            where("products.categoryId","=",$id)->
            select(["products.id as id", "products.name","products.image","products.categoryId"])->
            distinct()->
            get();

        $response = new Response(false);
        $response = $response->makeSuccessResponse($products, "Products of category retrieved successfuly");
        return $response;        
    }



}


?>