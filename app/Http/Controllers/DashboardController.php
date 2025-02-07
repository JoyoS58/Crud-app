<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum'); // Pastikan user sudah login sebelum akses dashboard
    // }
    /**
     * DashboardController constructor.
     * Pastikan hanya pengguna yang terautentikasi dapat mengakses controller ini.
     */

    /**
     * Menampilkan halaman dashboard utama.
     *
     * @return \Illuminate\View\View
     */
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Pastikan user sudah login sebelum akses dashboard
    // }
    public function index()
    {
        // dd(auth()->user());
        // // // Ambil data pengguna yang terautentikasi
        // $user = auth()->user();

        // Cek apakah pengguna sudah terautentikasi
        // if (!$user) {
        //     return redirect()->route('login'); // Arahkan pengguna ke halaman login jika belum terautentikasi
        // }

        // Tentukan tampilan berdasarkan role_id
        // if ($user->role_id == '1') {
        //     return view('dashboard.admin');  // Tampilan admin
        // } elseif ($user->role_id == '2') {
        //     return view('dashboard.member'); // Tampilan member
        // } else {
        //     return view('dashboard.user');   // Tampilan user biasa
        // }
        // return view('dashboard.admin');
        if (Auth::check()) {
            $user = auth()->user();
            // return view('dashboard.admin');
            if ($user->role_id == '1') {
                    return view('dashboard.admin');  // Tampilan admin
                } elseif ($user->role_id == '2') {
                    return view('dashboard.member'); // Tampilan member
                } else {
                    return view('dashboard.user');   // Tampilan user biasa
                }
        }
        return redirect()->route('login')->with('error', 'Silakan login dulu.');
    }
}
