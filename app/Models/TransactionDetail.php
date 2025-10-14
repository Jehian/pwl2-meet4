<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'detail_transaksi_penjualan';
    protected $fillable = [
        'id_transaksi_penjualan', 'id_product', 'jumlah_pembelian'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaksi_penjualan');
    }
}
