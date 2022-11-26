<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\StoreService;
use App\ApiResponse;
use Illuminate\Support\Facades\Validator;

class StoreController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StoreService $storeService)
    {
        return $this->sendResponse($storeService->index(), "Stores retrieved successfuly.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, StoreService $storeService)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'category' => ['required','numeric'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation error', $validator->errors(),400);       
        }          

        $apiResponse = $storeService->create($request);
    }

    public function get(int $id, StoreService $storeService)
    {
        return $this->response($storeService->get($id));
    }

    public function getAddress(int $id, StoreService $storeService)
    {
        return $this->response($storeService->getAddress($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
