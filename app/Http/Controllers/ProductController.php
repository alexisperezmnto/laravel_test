<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::orderBy('id', 'DESC')->with('categories')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required|min:15|max:800',
            'category' => 'required'
        ],
        [
            'name.required' => 'El campo nombre del producto es obligatorio',
            'price.required' => 'El campo precio del producto es obligatorio',
            'description.required' => 'El campo descripción del producto es obligatorio',
            'description.min' => 'El campo descripción debe tener entre 15 hasta 800 caracteres',
            'description.max' => 'El campo descripción debe tener entre 15 hasta 800 caracteres',
            'category.required' => 'El campo categoría del producto es obligatorio'
        ]);

        $request['slug'] = Str::slug($request['name']);

        //Image

        $product = Product::create($request->all());

        $product->categories()->attach($request['category']);

        return Product::with('categories')->find($product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {   
        $product = Product::with('user')->with('categories')->where('slug', $slug)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required|min:15|max:800',
            'category' => 'required'
        ],
        [
            'name.required' => 'El campo nombre del producto es obligatorio',
            'price.required' => 'El campo precio del producto es obligatorio',
            'description.required' => 'El campo descripción del producto es obligatorio',
            'description.min' => 'El campo descripción debe tener entre 15 hasta 800 caracteres',
            'description.max' => 'El campo descripción debe tener entre 15 hasta 800 caracteres',
            'category.required' => 'El campo categoría del producto es obligatorio'
        ]);

        $request['slug'] = Str::slug($request['name']);
        
        $product = Product::find($id);
        $product->update($request->all());

        $product->categories()->detach();
        $product->categories()->attach($request['category']);

        return Product::with('categories')->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $product = Product::find($id);
        // $product->categories()->detach();
        
        $result = Product::destroy($id);

        if(!$result) {
            return [
                'error' => 'Hubo un error'
            ];
        } 

        return [
            'message' => 'Producto eliminado correctamente'
        ];
    }

    
    public function search($name)
    {
        return Product::with('user')->with('categories')
                        ->where('name', 'like', '%'.$name.'%')
                        ->orWhere('description', 'like', '%'.$name.'%')
                        ->get();
    }

    public function user_products() {
        $user = auth()->user('id');
        return Product::with('user')->with('categories')->where('user_id', $user->id)->get();
    }
}
