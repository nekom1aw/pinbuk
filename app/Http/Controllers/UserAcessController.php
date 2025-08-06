<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAcessController extends Controller
{
    public function indexbuku()
    {
        return view('user.buku-index');
    }

    public function show($id)
    {
        // Kirim ID ke view
        return view('user.buku-detail', ['bukuId' => $id]);
    }
    public function view($id)
    {
        // Kirim ID ke view
        return view('user.buku-view', ['bukuId' => $id]);
    }

    public function katalog($id)
    {
        // Kirim ID ke view
        return view('user.katalog-buku', ['kategoriId' => $id]);
    }

    public function key($key)
    {
        return view('user.search-result', ['nama' => $key]);
    }
}
