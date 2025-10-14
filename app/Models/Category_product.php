<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    protected $table = 'category_product';

    protected $fillable = ['product_category_name'];

    public function get_category_product(){
        //get all category_product
        $sql = $this->select("*");

        return $sql;
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    public function category_product()
    {
        return $this->belongsTo(Category_product::class, 'product_category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}

