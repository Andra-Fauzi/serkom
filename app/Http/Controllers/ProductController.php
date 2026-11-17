<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function landing() {
        $products = Product::query()->latest()->get();

        return view('landing', compact('products'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::query()->latest()->get();
        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'string', 'max:255']
        ], $this->validationMessage());
        Product::query()->create($validated);

        return redirect()->route('produk.index')->with('success', "Produk Berhasil Ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $produk)
    {
        //
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $produk)
    {
        //
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'integer', 'min:0'],
            'gambar' => ['string', 'nullable', 'max:255']
        ], $this->validationMessage());

        $produk->update($validated);

        return redirect()->route('produk.index')->with("success", "Produk Berhasil Diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $produk)
    {
        //
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk Berhasil Dihapus');
    }

    private function validationMessage() {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa bilangan bulat.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'gambar.max' => 'Nama file gambar maksimal 255 karakter.',
        ];

    }
}
