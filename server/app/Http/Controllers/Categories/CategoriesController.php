<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Helpers\Http\Respond;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $index = Category::whereIsRoot()->with('children')->ordered()->get();

        return Respond::make(
            CategoryResource::collection($index)
        );
    }
}
