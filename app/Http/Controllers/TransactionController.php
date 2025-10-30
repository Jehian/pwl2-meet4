<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionMail;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::with('details.product')->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'required|email',
            'tanggal_transaksi' => 'required|date',
            'product_id' => 'required|array',
            'jumlah_pembelian' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // Simpan data transaksi utama
            $transaction = Transaction::create([
                'nama_kasir' => $request->nama_kasir,
                'email_pembeli' => $request->email_pembeli,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            // Simpan detail transaksi
            foreach ($request->product_id as $index => $productId) {
                TransactionDetail::create([
                    'id_transaksi_penjualan' => $transaction->id,
                    'id_product' => $productId,
                    'jumlah_pembelian' => $request->jumlah_pembelian[$index],
                ]);
            }

            DB::commit();

            // ✅ Kirim email setelah transaksi sukses disimpan
            $this->sendEmail($transaction->email_pembeli, $transaction->id);

            return redirect()->route('transactions.index')->with(['success' => 'Data Transaksi Berhasil Disimpan dan Email Berhasil Dikirim!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }

    public function show(string $id): View
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit(string $id): View
    {
        $transaction = Transaction::with('details')->findOrFail($id);
        $products = Product::all();
        return view('transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'required|email',
            'tanggal_transaksi' => 'required|date',
            'product_id' => 'required|array',
            'jumlah_pembelian' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->update([
                'nama_kasir' => $request->nama_kasir,
                'email_pembeli' => $request->email_pembeli,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            $transaction->details()->delete();

            foreach ($request->product_id as $index => $productId) {
                TransactionDetail::create([
                    'id_transaksi_penjualan' => $transaction->id,
                    'id_product' => $productId,
                    'jumlah_pembelian' => $request->jumlah_pembelian[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('transactions.index')->with(['success' => 'Data Transaksi Berhasil Diubah!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->details()->delete();
            $transaction->delete();

            DB::commit();
            return redirect()->route('transactions.index')->with(['success' => 'Data Transaksi Berhasil Dihapus!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Gagal menghapus transaksi: ' . $e->getMessage()]);
        }
    }

    /**
     * Kirim email transaksi ke pembeli
     */
    public function sendEmail($to, $id)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with('details.product')->findOrFail($id);

        // Hitung total harga
        $total_harga = 0;
        foreach ($transaction->details as $detail) {
            $total_harga += $detail->jumlah_pembelian * $detail->product->price;
        }

        // Ubah subject email agar ada total harga
        $subject = "Transaksi Penjualan - Total Rp " . number_format($total_harga, 2, ',', '.');

        // Kirim menggunakan Mailable
        Mail::to($to)->send((new TransactionMail($transaction))->subject($subject));

        return response()->json(['message' => 'Email sent successfully!']);
    }
}
