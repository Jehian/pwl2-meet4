<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'supplier_id',
        'product_category_id',
        'description',
        'price',
        'stock',
    ];

    /**
     * Tambahkan metode untuk menyimpan data
     */
    public static function storeProduct($request, $image)
    {
        // Simpan produk baru menggunakan mass assignment
        return self::create([
            'image'                => $image->hashName(),
            'title'                => $request->title,
            'supplier_id'          => $request->supplier,
            'product_category_id'  => $request->product_category_id,
            'description'          => $request->description,
            'price'                => $request->price,
            'stock'                => $request->stock,
        ]);
    }

    public function get_product()
    {
        $sql = $this->select(
                        "products.*", 
                        "category_product.product_category_name as product_category_name", 
                        "supplier.supplier_name as supplier_name"
                    )
                    ->leftJoin('category_product', 'category_product.id', '=', 'products.product_category_id')
                    ->leftJoin('supplier', 'supplier.id', '=', 'products.supplier_id'); //join antara tabel suppliers dan products

        return $sql;
    }
}
