<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; //validasi
use Illuminate\Validation\ValidationException; //untuk login
  
class AuthController extends Controller
{
    public function register()
    {
        // merujuk kepada lokasi tampilan yang sesuai dalam struktur direktori tampilan (views) di dalam proyek Laravel
        return view('auth/register');
    }
  
    public function registerSave(Request $request)
    {
        // Fungsi ini menerima parameter $request, yang adalah instance dari kelas Request. 
        // Dalam konteks Laravel, $request mengandung data yang dikirimkan oleh pengguna melalui formulir pendaftaran.
        Validator::make($request->all(), [
            // menggunakan Laravel's Validator untuk memeriksa inputan (sudah sesuai dengan aturan validasi yang didefinisikan)
            // jika tidak cocok, maka akan dihasilkan pesan kesalahan yang akan ditampilkan kepada pengguna
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();
        
        User::create([ // menggunakan model Laravel bernama User untuk membuat entri baru ini
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), //yang di-hash menggunakan Hash::make untuk keamanan
            'level' => 'Admin'
        ]);
  
        return redirect()->route('login'); // setelah semua proses berhasil, akan diarahkan ke halaman login
        // 
    }
  
    public function login()
    {
        // merujuk kepada lokasi tampilan struktur direktori tampilan (views) di dalam proyek Laravel
        return view('auth/login');
    }
  
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        // menggunakan Auth::attempt() untuk mencoba masuk (login) pengguna dengan alamat email
        // dan kata sandi yang diberikan dalam $request
        // jika berhasil, akan maka akan melakukan proses berikutnya
        // jika salah, akan ada ValidationException dengan pesan kesalahan yang sesuai
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        // menggunakan metode ini untuk memperbarui identifikasi sesi pengguna
        $request->session()->regenerate();

        // jika pengguna berhasil diautentikasi, mereka akan diarahkan (redirect) ke halaman dashboard
        return redirect()->route('dashboard');
    }
  
    public function logout(Request $request)
    {
        // Auth::guard('web') untuk mengakses guard (pelindung) dengan nama 'web' yang
        // biasanya digunakan untuk mengelola otentikasi pengguna
        // Metode logout() digunakan untuk mengakhiri sesi (session) pengguna
        // dan menghapus data otentikasi user
        Auth::guard('web')->logout();

        // metode ini untuk menghapus atau menghentikan sesi pengguna secara efektif
        // langkah keamanan penting untuk mencegah pengguna sebelumnya yang telah keluar
        // untuk tetap memiliki akses ke sesi yang sudah tidak valid
        $request->session()->invalidate();
  
        //diarahkan ke halaman beranda
        return redirect('/');
    }
 
    public function profile()
    {
        // merujuk ke direktori
        return view('profile');
    }
}