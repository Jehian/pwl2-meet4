<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = ['supplier_name', 'pic_supplier'];

    public function get_category_product(): Supplier{
        //get all category suppliers
        $sql = $this->select("supplier");

        return $sql;
    }
}
