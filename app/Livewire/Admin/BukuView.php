<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BukuView extends Component
{
    public $buku;

    public function mount($id): void
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
