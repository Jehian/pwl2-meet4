<?php

namespace App\Http\Controllers;

use App\Models\Category_product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * index
     * 
     * @return View
     */
    public function index(): View
    {
        // Ambil semua kategori
        $categories = Category_product::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * create
     * 
     * @return View
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * store
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_category_name' => 'required|string|max:100',
        ]);

        try {
            Category_product::create([
                'product_category_name' => $request->product_category_name,
            ]);

            return redirect()->route('categories.index')->with(['success' => 'Kategori berhasil disimpan!']);
        } catch (\Exception $e) {
            return back()->withInput()->with(['error' => 'Gagal menyimpan kategori: ' . $e->getMessage()]);
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
        $category = Category_product::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * edit
     * 
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $category = Category_product::findOrFail($id);
        return view('categories.edit', compact('category'));
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
            'product_category_name' => 'required|string|max:100',
        ]);

        try {
            $category = Category_product::findOrFail($id);
            $category->update([
                'product_category_name' => $request->product_category_name,
            ]);

            return redirect()->route('categories.index')->with(['success' => 'Kategori berhasil diperbarui!']);
        } catch (\Exception $e) {
            return back()->withInput()->with(['error' => 'Gagal memperbarui kategori: ' . $e->getMessage()]);
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
        try {
            $category = Category_product::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.index')->with(['success' => 'Kategori berhasil dihapus!']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'Gagal menghapus kategori: ' . $e->getMessage()]);
        }
    }
}
