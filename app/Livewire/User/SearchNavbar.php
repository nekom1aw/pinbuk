<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SearchNavbar extends Component
{
    public $query = '';

    public $results = [];

    public function updatedQuery(): void
    {
        $this->results = DB::table('buku')
            ->where('nama_buku', 'like', '%'.$this->query.'%')
            ->limit(5)
            ->get();
    }

    public function goToBuku($id)
    {
        return redirect()->route('user.buku.detail', ['id' => $id]);
    }

    public function search()
    {
        $trimmed = trim($this->query);

        if ($trimmed !== '') {
            return redirect('user/buku/search/'.urlencode($trimmed));
        }
    }

    public function render()
    {
        return view('livewire.user.search-navbar');
    }
}
