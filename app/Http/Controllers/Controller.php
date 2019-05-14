<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Product;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Store a new product
     *
     * @param StoreProductRequest $request
     *
     * @return Product
     */
    public function storeProduct(StoreProductRequest $request)
    {
        $product = new Product();

        // Note: usage of whitelisted properties
        $product->fill($request->only(['name', 'description', 'price']));
        $product->save();

        if(!$request->wantsJson()) {
            return redirect()->back();
        }

        return $product;
    }

    /**
     * List all the products
     *
     * @return Product[]
     */
    public function listProducts()
    {
        return Product::all();
    }
}
