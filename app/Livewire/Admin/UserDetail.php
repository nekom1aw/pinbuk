<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class UserDetail extends Component
{
    public $user;

    public $confirmingDelete = false;

    public function mount($id): void
    {
        $this->user = DB::table('pengguna')->where('id', $id)->first();
    }

    public function confirmDelete(): void
    {
        $this->confirmingDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = false;
    }

    public function deleteUser()
    {
        if ($this->user->foto) {
            Storage::delete('public/'.$this->user->foto);
        }

        DB::table('pengguna')->where('id', $this->user->id)->delete();

        session()->flash('message', 'User berhasil dihapus.');

        return redirect('/admin/users');
    }

    public function render()
    {
        return view('livewire.admin.user-detail');
    }
}
