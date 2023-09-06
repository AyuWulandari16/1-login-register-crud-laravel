<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Product;
 
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Untuk detail barang
    public function index()
    {
        // menggunakan model Laravel Product untuk mengambil data produk dari database
        // mengurutkan data produk berdasarkan kolom 'created_at' secara descending (dari yang terbaru ke yang terlama) menggunakan orderBy('created_at', 'DESC')
        // kemudian menggunakan get() untuk mengambil seluruh data produk dari tabel produk
        $product = Product::orderBy('created_at', 'DESC')->get();
  
        // mengirimkan data tersebut ke tampilan dengan nama 'products.index' 
        // fungsi compact() untuk membuat variabel dengan nama 'product' yang akan digunakan
        // dalam tampilan. Ini memungkinkan untuk menampilkan daftar produk dalam tampilan indeks
        return view('products.index', compact('product'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ketika metode ini diakses, ia hanya mengembalikan tampilan dengan nama 'products.create'.
        return view('products.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    // method yang digunakan untuk menangani penyimpanan produk baru kedalam database
    // menerima parameter request yang berisi data yang dikirimkan oleh user
    public function store(Request $request)
    {
        // Product mengarah ke models
        // membuat entri baru dalam database berdasarkan data yang diterima dari $request
        Product::create($request->all());
 
        // setelah berhasil disimpan, user akan diarahkan kembali ke route products,
        // dengan pesan sukses ('success') yang akan ditampilkan
        return redirect()->route('products')->with('success', 'Product added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    // method mengambil parameter string $id
    // parameter ini akan digunakan untuk mengidentifikasi produk yang akan ditampilkan
    public function show(string $id)
    {
        // menggunakan model Laravel Product untuk mencari produk dengan ID yang sesuai dalam database
        // findOrFail($id) digunakan untuk mencari produk berdasarkan ID yang diberikan
        $product = Product::findOrFail($id);
  
        // setelah id ditemukan, data produk tersebut dikirimkan ke tampilan dengan nama products.show
        // Data produk ini dibungkus dalam variabel $product dan dikirimkan ke tampilan menggunakan
        // fungsi compact(). Ini memungkinkan tampilan untuk menampilkan detail produk tersebut
        return view('products.show', compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
  
        return view('products.edit', compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
  
        $product->update($request->all());
  
        return redirect()->route('products')->with('success', 'product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
  
        $product->delete();
  
        return redirect()->route('products')->with('success', 'product deleted successfully');
    }
}