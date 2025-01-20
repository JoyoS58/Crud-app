<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     * Pastikan hanya pengguna yang terautentikasi dapat mengakses controller ini.
     */

    /**
     * Menampilkan halaman dashboard utama.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }
}
