<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product;
use App\Models\Category_product;
use App\Models\Supplier;

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Facades Storage
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index() : View
    {
        //get all products
        $product = new Product;
        $products = $product->get_product()->latest()->paginate(10);

        //render view with products
        return view('products.index', compact('products'));
    }

    /**
     * create
     * 
     * @return View
     */
    public function create() : View
    {
        $product = new Category_Product;
        $data['categories'] = $product->get_category_product()->get();

        $product = new Supplier;
        $data['suppliers'] = Supplier::all();

        return view('products.create', compact('data'));
    }

    /**
     * store
     * 
     * @param mixed @request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // var_dump($request);exit;
        //validate form
        $validatedData = $request->validate([
            'image'                 => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'title'                 => 'required|min:5',
            'product_category_id'   => 'required|integer',
            'description'           => 'required|min:10',
            'price'                 => 'required|numeric',
            'stock'                 => 'required|numeric',
        ]);

        // Menghandle upload file gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $store_image = $image->store('images', 'public'); // Simpan gambar ke folder penyimpanan

            $product = new Product;
            $insert_product = $product->storeProduct($request, $image);

            //redirect to index
            return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }

        //redirect to index
        return redirect()->route('products.index')->with(['error' => 'Failed to upload image (request).']);
    }

    /**
     * show
     * 
     * @param mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get product by ID
        $product_model = new Product;
        $product = $product_model->get_product()->where("products.id", $id)->firstOrFail();

        //render view with product
        return view('products.show', compact('product'));
    }

    /**
     * edit
     * 
     * @param mixed $id
     * @return View
     */
    public function edit (string $id): View
    {
        //get product by ID
        $product_model = new Product;
        $data['product'] = $product_model->get_product()->where("products.id", $id)->firstOrFail();

        $data['categories'] = Category_product::all();
        $data['suppliers_'] = Supplier::all();

        //render view with product
        return View('products.edit', compact('data'));
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {   
        //validate form
        $request->validate([
            'image'                 => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            'title'                 => 'required|min:5',
            'description'           => 'required|min:10',
            'price'                 => 'required|numeric',
            'stock'                 => 'required|numeric',
            'product_category_id'   => 'required|integer',
            'id_supplier'           => 'required|integer',
        ]);

        //get product by ID
        $product_model = new Product;
        
        $name_image = null;

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $store_image = $image->store('images', 'public'); //simpan gambar ke folder storage
            $name_image = $image->hashName();

            //cari data product berdasarkan id
            $data_product = $product_model->get_product()->where("products.id", $id)->firstOrFail();
            //delete old image
            Storage::disk('public')->delete('images/'.$data_product->image);
        }

        //update product with new image
        $request =[
            'judul'                 => $request->title,
            'supplier_id'           => $request->id_supplier,
            'product_category_id'   => $request->product_category_id,
            'description'           => $request->description,
            'price'                 => $request->price,
            'stock'                 => $request->stock
        ];

        $update_product = $product_model->updateProduct($id, $request, $name_image);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil diubah!']);
    }

    /**
     * destroy
     * 
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get product by ID
        $product_model = new Product;
        $product = $product_model->get_product()->where("products.id", $id)->firstOrFail();

        //delete old image
            Storage::disk('public')->delete('images/'.$product->image);

        //delete product
        $product->delete();

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil  dihapus']);
    }

    // ==============================
    // BAGIAN API
    // ==============================

    /**
     * API: Get all products (JSON)
     */
    public function apiIndex()
    {
        $product = new Product;
        $products = $product->get_product()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * API: Get single product by ID (JSON)
     */
    public function apiShow($id)
    {
        $product = new Product;
        $productData = $product->get_product()->where("products.id", $id)->first();

        if (!$productData) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $productData
        ]);
    }
}