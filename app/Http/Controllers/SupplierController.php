<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    /**
     * index
     * 
     * @return View
     */
    public function index()
    {
        $suppliers = \App\Models\Supplier::paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }


    /**
     * create
     * 
     * @return View
     */
    public function create(): View
    {
        // Tampilkan form tambah supplier
        return view('suppliers.create');
    }

    /**
     * store
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data input
        $request->validate([
            'supplier_name' => 'required|string|max:100',
            'pic_supplier' => 'required|string|max:100',
        ]);

        // Simpan ke database
        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'pic_supplier' => $request->pic_supplier,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('suppliers.index')->with(['success' => 'Data Supplier Berhasil Disimpan!']);
    }

    /**
     * show
     * 
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        // Ambil data supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Tampilkan ke view
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * edit
     * 
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Ambil data supplier
        $supplier = Supplier::findOrFail($id);

        // Kirim ke form edit
        return view('suppliers.edit', compact('supplier'));
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
        // Validasi data
        $request->validate([
            'supplier_name' => 'required|string|max:100',
            'pic_supplier' => 'required|string|max:100',
        ]);

        // Update data suppliers
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'pic_supplier' => $request->pic_supplier,
        ]);

        return redirect()->route('suppliers.index')->with(['success' => 'Data Supplier Berhasil Diperbarui!']);
    }

    /**
     * destroy
     * 
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        // Hapus data supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with(['success' => 'Data Supplier Berhasil Dihapus!']);
    }
}
