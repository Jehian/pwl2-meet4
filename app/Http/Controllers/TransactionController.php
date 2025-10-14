<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * index
     * 
     * @return View
     */
    public function index(): View
    {
        // Ambil semua transaksi beserta detail dan produk terkait
        $transactions = Transaction::with('details.product')->latest()->paginate(10);

        // Tampilkan ke view
        return view('transactions.index', compact('transactions'));
    }

    /**
     * create
     * 
     * @return View
     */
    public function create(): View
    {
        // Ambil semua produk untuk dropdown pemilihan
        $products = Product::all();

        // Tampilkan form create transaksi
        return view('transactions.create', compact('products'));
    }

    /**
     * store
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'required|email',
            'tanggal_transaksi' => 'required|date',
            'product_id' => 'required|array',
            'jumlah_pembelian' => 'required|array',
        ]);

        // Transaksi database agar aman dari error
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
            return redirect()->route('transactions.index')->with(['success' => 'Data Transaksi Berhasil Disimpan!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }

    /**
     * show
     * 
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        // Ambil transaksi beserta detail dan produk
        $transaction = Transaction::with('details.product')->findOrFail($id);

        // Tampilkan ke view
        return view('transactions.show', compact('transaction'));
    }

    /**
     * edit
     * 
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Ambil transaksi dan semua produk
        $transaction = Transaction::with('details')->findOrFail($id);
        $products = Product::all();

        // Kirim ke form edit
        return view('transactions.edit', compact('transaction', 'products'));
    }

    /**
     * update
     * 
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
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

            // hapus detail lama
            $transaction->details()->delete();

            // tambahkan detail baru
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

            // kirim error ke session
            return back()->withInput()->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    /**
     * destroy
     * 
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Hapus data transaksi dan detailnya
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
}
