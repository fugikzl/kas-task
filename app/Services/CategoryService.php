<?php
namespace App\Services;

use App\ApiResponse\Response;
use App\Models\Category;

class CategoryService
{
    /**
     * Get category by it's id
     * 
     * @param int $id id of category 
     * 
     */
    public function get(int $id)
    {
        $category = Category::where("id",$id)->get()->first();
        if($category){
            $response = new Response(false);
            $response->makeSuccessResponse($category,'Category retieved successfuly');
        }else{
            $response = new Response(true);
            $response->makeErrorResponse("Not found");
        }
        
        return $response;
    }

    public function index()
    {
        $category = Category::all();
        $response = new Response(false);
        $response->makeSuccessResponse($category,'Categories retieved successfuly');
        return $response;   
    }

}

?>