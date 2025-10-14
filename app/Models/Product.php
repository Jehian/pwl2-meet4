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

    public function get_product(){
        //get all products
        $sql = $this->select("products.*", "category_product.product_category_name as product_category_name", "supplier.supplier_name as supplier_name")
                    ->leftjoin('category_product', 'category_product.id', '=', 'products.product_category_id')
                    ->leftjoin('supplier', 'supplier.id', '=', 'products.supplier_id');
                    
        return $sql;
    }

    public static function storeProduct($request, $image)
    {
        return self::create([
            'image'                 => $image->hashName(),
            'title'                 => $request->title,
            'supplier_id'           => $request->supplier_id,
            'product_category_id'   => $request->product_category_id,
            'description'           => $request->description,
            'price'                 => $request->price,
            'stock'                 => $request->stock,
        ]);
    }

    //Metode untuk edit data
    public static function updateProduct($id, $request, $image = null)
    {
        $product = self::find($id);

        if ($product) {
            $data = [
                'title'                 => $request['judul'],
                'supplier_id'           => $request['supplier_id'],
                'product_category_id'   => $request['product_category_id'],
                'description'           => $request['description'],
                'price'                 => $request['price'],
                'stock'                 => $request['stock']
            ];

            if (!empty($image)) {
                $data['image'] = $image;
            }

            $product->update($data);
            return $product;
            
        }else{
            return "tidak ada data yang diupdate";
        }
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function category()
    {
        return $this->belongsTo(Category_product::class, 'product_category_id');
    }
    
}
