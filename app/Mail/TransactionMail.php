<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $total; // tambahan variabel total harga

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;

        // Hitung total harga semua produk di transaksi
        $this->total = $this->transaction->details->sum(function ($detail) {
            return $detail->product->price * $detail->jumlah_pembelian;
        });
    }

    public function build()
    {
        // Format total ke dalam bentuk rupiah
        $formattedTotal = 'Rp ' . number_format($this->total, 2, ',', '.');

        return $this->subject("Transaksi Penjualan Toko Benny - Total: {$formattedTotal}")
                    ->view('transactions.email')
                    ->with([
                        'transaction' => $this->transaction,
                        'total' => $this->total,
                    ]);
    }
}
