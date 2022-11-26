<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    /**
     * get all categories
     */
    public function index(CategoryService $categoryService)
    {
        return $this->response($categoryService->index());
    }

    /**
     * get category by it's id
     * @param int $id
     */
    public function get(int $id, CategoryService $categoryService)
    {
        return $this->response($categoryService->get($id));
    }
}
