<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index() : View
    {
        // get all products
        $products = (new Product)->get_product()->latest()->paginate(10);

        // render view with products
        return view('products.index', compact('products'));
    }
}
