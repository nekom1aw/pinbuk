<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BukuView extends Component
{
    public $buku;

    public function mount($id)
    {
        $this->buku = DB::table('buku')->find($id);
    } 

    public function render()
    {
        return view('livewire.admin.buku-view', [
            'buku' => $this->buku,
        ]);
    }
}
