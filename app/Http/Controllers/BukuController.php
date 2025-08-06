<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $bukus = DB::table('buku')->get();
        return view('admin.buku-index', compact('bukus'));
    }
    public function kategori()
    {
        return view('admin.kategori-buku-index');
    }

    public function katebuku()
    {
        return view('admin.kategori-buku');
    }

    public function view($id)
    {
        return view('admin.buku-view', ['id' => $id]);
    }

    public function katedetail($id)
    {
        return view('admin.kategori-detail', ['kategoriId' => $id]);
    }
    public function kategoriSubkategori($kategoriId, $subkategoriId)
    {
        return view('admin.kategori-subkategori', [
            'kategoriId' => $kategoriId,
            'subkategoriId' => $subkategoriId,
        ]);
    }
    public function kategorisubkategori2($kategori, $sub1, $sub2)
    {
        return view('admin.kategori-subkategori2', [
            'kategoriId' => $kategori,
            'subkategori1Id' => $sub1,
            'subkategori2Id' => $sub2,
        ]);
    }





    // Menampilkan form untuk tambah buku
    public function create()
    {
        return view('admin.buku-tambah');
    }


    // Menampilkan form edit buku
    public function edit($id)
    {
        $buku = DB::table('buku')->where('id', $id)->first();
        return view('admin.buku-edit', compact('buku'));
    }

    public function pinjam($id)
    {
        $buku = DB::table('buku')->where('id', $id)->first();
        return view('admin.buku-pinjam', compact('buku'));
    }

    // Menampilkan detail buku
    public function show($id)
    {
        $buku = DB::table('buku')->where('id', $id)->first();
        return view('admin.buku-detail', compact('buku'));
    }
    public function printQr($id)
    {
        $buku = DB::table('buku')->where('id', $id)->first();

        if (!$buku) {
            return redirect()->route('admin.buku.index')->with('error', 'Buku tidak ditemukan.');
        }

        return view('admin.print-qr', compact('buku'));
    }


    // Menghapus buku
    public function destroy($id)
    {
        DB::table('buku')->where('id', $id)->delete();
        return redirect()->route('admin.buku.index')->with('message', 'Buku berhasil dihapus!');
    }
}
