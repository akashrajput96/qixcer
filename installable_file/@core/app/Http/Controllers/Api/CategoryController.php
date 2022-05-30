<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function category(){
        $category = Category::select('name','icon')->where('status',1)->get();
        if($category){
            return response()->success([
                'category'=>$category,
            ]);
        }
        return response()->error([
            'message'=>'Category Not Available',
        ]);
    }
}
