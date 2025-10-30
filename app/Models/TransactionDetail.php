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

    public function sendEmail($to, $id)
    {
        // Ambil transaksi berdasarkan ID, termasuk detail dan produk
        $transaction = Transaction::with('details.product')->findOrFail($id);

        // Hitung total harga transaksi
        $total_harga['transaksi'] = 0;
        foreach ($transaction->details as $detail) {
            $total_harga['transaksi'] += $detail->jumlah_pembelian * $detail->product->harga;
        }

        // Data yang akan dikirim ke view email
        $transaksi_ = [
            'transaction' => $transaction,
            'total_harga' => $total_harga
        ];

        // Mengirim email menggunakan view 'transactions.show'
        Mail::send('transactions.show', $transaksi_, function ($message) use ($to, $transaction, $total_harga) {
            $message->to($to)
                ->subject(
                    "Transaksi Detail: {$transaction->email_pembeli} - Total Tagihan Rp " .
                    number_format($total_harga['transaksi'], 2, ',', '.')
                );
        });

        return response()->json(['message' => 'Email sent successfully!']);
    }


}
