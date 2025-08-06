<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    public function __construct()
    {
        $this->cekJatuhTempo(); // ✅ otomatis jalan
    }

    public function cekJatuhTempo()
    {
        DB::table('peminjaman')
            ->whereIn('status', ['dipinjam', 'request', 'silahkan di ambil'])
            ->whereDate('tanggal_kembali', '<', Carbon::now())
            ->update(['status' => 'jatuh tempo']);
    }
}
