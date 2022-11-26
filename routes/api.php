<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreController;



Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register'); // make register
    Route::post('login', 'login'); // make an login, returns token and user info
});

Route::prefix("product")->group(function(){
    Route::controller(ProductController::class)->group(function(){
        Route::get("/",'getActiveProducts'); //get all active products
        Route::get("/all",'index'); //get all products (includes oriducts that doesnt have a offer 
        Route::get("/{id}",'get'); //get product by id
        
        Route::post("/",'create'); //create product
        Route::post("/{id}",'update'); //update product by id

        Route::get("/store/{id}",'getStoreOffers'); //get offers products of store
        Route::get("/{id}/offers/",'getOffers'); //get offers by product id
        Route::get("/category/{id}","getByCategory"); //get active products by category
    });
});

Route::prefix("store")->group(function(){
    Route::controller(StoreController::class)->group(function(){
        Route::get("/",'index'); //get all stores
        Route::get("/{id}",'get'); // get store by id
        Route::get("/{id}/address",'getAddress'); //get address of store by id
    });
});

Route::prefix("category")->group(function(){
    Route::controller(CategoryController::class)->group(function(){
        Route::get("/",'index'); // get all categories
        Route::get("/{id}",'get'); // get category by id
    });
    
});