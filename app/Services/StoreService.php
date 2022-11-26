<?php
namespace app\Services;
use App\Models\Store;
use Illuminate\Http\Request;
use App\ApiResponse\Response;
use App\Models\StorePoint;

class StoreService
{
    public function index()
    {
        return Store::all();
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $store = Store::create($input);
        $response = new Response(false);
        $response = $response->makeSuccessResponse($store, "Store created successfuly");
        return $response;
    }

    public function get(int $id)
    {
        $store = Store::where("id",$id)->get()->first();
        $response = new Response(false);
        $response = $response->makeSuccessResponse($store, "Store retrieved successfuly");
        return $response;
    }

    public function getAddress(int $id)
    {
        $storePoints = StorePoint::where("storeId",$id)->get(["address","lat","lng"]);
        $response = new Response(false);
        $response = $response->makeSuccessResponse($storePoints, "Store addresses retrieved successfuly");
        return $response;
    }
}


?>