<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaksi_penjualan';
    protected $fillable = [
        'nama_kasir', 'email_pembeli', 'tanggal_transaksi'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaksi_penjualan');
    }
}
