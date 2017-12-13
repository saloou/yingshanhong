<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return Product::paginate(6);
    }
    public function show(Product $product){
        return $product;
    }
    public function create(Request $request){
        $data = [
            'pName'   => $request->get('pName'),
            'oPrice'    =>  $request->get('oPrice'),
            'nPrice'    =>  $request->get('nPrice'),
            'stock'    =>  $request->get('stock'),
            'description'=> $request->get('description'),
            'photo'=> $request->get('photo'),
            'categoryId'=> $request->get('categoryId'),
        ];


//        return $data;

        return Product::create($data);


    }
}
