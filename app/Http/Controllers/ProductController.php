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
     * @return View
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

        $supplier = new Supplier;
        $data['suppliers'] = $supplier->get_supplier()->get();

        return view('products.create', compact('data'));
    }

    /**
     * store
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $validatedData = $request->validate([
            'image'                 => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'                 => 'required|min:5',
            'supplier'              => 'required|integer',
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
     * @param string $id
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
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get product by ID
        $product_model = new Product;
        $data['product'] = $product_model->get_product()->where("products.id", $id)->firstOrFail();

        $category_model = new Category_Product;
        $product['categories'] = $category_model->get_category_product()->get();

        $supplier_model = new Supplier;
        $product['suppliers'] = $supplier_model->get_supplier()->get();

        $merged = array_merge($data, $product);
        
        //render view with product
        return view('products.edit', compact(   'merged'));
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
        //Validate Form
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);
    
        //get product by ID 
        $product_model = new Product;

        $name_image = null;

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $store_image = $image->store('images', 'public'); // Simpan gambar ke folder penyimpanan
            $name_image = $image->hashName();

            //cari data product berdasarkan id
            $data_product = $product_model->get_product()->where("products.id", $id)->firstOrFail();

            //delete old image
            Storage::disk('public')->delete('images/' . $data_product->image);

        }
        //update product with new image
        $request = [
            'title'              => $request->title,
            'product_category_id'=> $request->product_category_id,
            'supplier_id'        => $request->supplier,
            'description'        => $request->description,
            'price'              => $request->price,
            'stock'              => $request->stock,
        ];

        $update_product = $product_model->updateProduct($id, $request, $name_image);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get product by ID
        $product_model = new Product;
        $product = $product_model->get_product()->where("products.id", $id)->firstOrFail();

        //delete old image
        Storage::disk('public')->delete('images/' . $product->image);

        //delete product
        $product->delete();

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
