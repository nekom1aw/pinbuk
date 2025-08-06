<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = '';
    public $filterJabatan = '';
    public $filterStatus = '';

    public $showModal = false;
    public $isEdit = false;

    public $showAddModal = false;
    public $showEditModal = false;

    public $foto;
    public $foto_lama;



    public $userId, $nama, $email, $jabatan, $status, $no_tlpn, $nip;
    public $password, $password_confirmation;
    public $isAdmin = false;
    public $confirm_password;


    public $jabatanOptions = ['Staff', 'Manager', 'Supervisor', 'Karyawan'];
    public $statusOptions = [];
    public $level = 'user';   // default user




    // panggil saat klik “Tambah Admin”
    public function showAddAdminForm()
    {
        $this->resetForm();
        $this->isAdmin  = true;
        $this->level    = 'admin';
        $this->showAddModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }


    public function mount()
    {
        $this->statusOptions = $this->getEnumValues('pengguna', 'status');
    }

    protected function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;
        preg_match('/enum\((.*)\)/', $type, $matches);
        return array_map(fn($val) => trim($val, "'"), explode(',', $matches[1]));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterJabatan()
    {
        $this->resetPage();
    }
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function searchUsers()
    {
        $query = DB::table('pengguna');

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }

        if ($this->filterJabatan) {
            $query->where('jabatan', 'like', '%' . $this->filterJabatan . '%');
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        return $query->orderBy('updated_at', 'desc')->paginate(12);
    }

    public function create()
    {
        $this->reset([
            'userId',
            'nama',
            'email',
            'no_tlpn',
            'jabatan',
            'status',
            'nip',
            'password',
            'confirm_password'
        ]);

        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {

        $this->reset(['showAddModal']); // pastikan modal tambah dimatiin
        $this->showEditModal = true;
        $user = DB::table('pengguna')->find($id);

        if ($user) {
            $this->userId = $user->id;
            $this->nama = $user->nama;
            $this->email = $user->email;
            $this->no_tlpn = $user->no_tlpn;
            $this->isEdit = true;
            $this->showModal = true;

            // Reset password fields
            $this->password = '';
            $this->password_confirmation = '';
            $this->foto_lama = $user->foto;

            // Tentukan apakah admin atau bukan
            if ($user->level === 'admin') {
                $this->isAdmin = true;
            } else {
                $this->isAdmin = false;
                $this->jabatan = $user->jabatan;
                $this->status = $user->status;
                $this->nip = $user->nip;
            }
        }
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $this->userId,
            'no_tlpn' => 'nullable|string|max:20',
            'password' => 'nullable|min:6|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6',
            'nip' => $this->isAdmin ? 'nullable' : 'nullable|string|max:30',
            'jabatan' => $this->isAdmin ? 'nullable' : 'required|string',
            'status' => $this->isAdmin ? 'nullable' : 'required|in:green,yellow,red,black',
            'foto' => 'nullable|image|max:1024',
        ]);

        $data = [
            'nama' => $this->nama,
            'email' => $this->email,
            'no_tlpn' => $this->no_tlpn,
        ];

        // Jika user biasa, tambahkan kolom tambahan
        if (!$this->isAdmin) {
            $data['nip'] = $this->nip;
            $data['jabatan'] = $this->jabatan;
            $data['status'] = $this->status;
        }

        if ($this->foto) {
            $path = $this->foto->store('images/user', 'public');
            $data['foto'] = '/storage/' . $path;
        } else {
            // ✅ Jika tidak upload foto baru, gunakan foto lama
            $data['foto'] = $this->foto_lama;
        }

        // Jika isi password baru, simpan
        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
            $data['password_plaintext'] = $this->password;
        }

        // Simpan ke database
        DB::table('pengguna')->where('id', $this->userId)->update($data);

        // Reset form
        $this->resetForm();

        // Tutup modal
        $this->showEditModal = false;

        // Refresh data dan tampilkan notifikasi jika perlu
        session()->flash('success', 'Data pengguna berhasil diperbarui.');
    }



    public function showAddForm()
    {
        $this->resetValidation();
        $this->reset(); // atau reset field-field tertentu saja
        $this->showAddModal = true;
    }



    public function save()
    {
        // Validasi umum
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'no_tlpn' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'nullable|image|max:1024',
            'jabatan' => $this->isAdmin ? 'nullable' : 'required|string|max:100',
            'nip' => $this->isAdmin ? 'nullable' : 'required|string|max:50|unique:pengguna,nip',
        ]);

        $fotoPath = null;
        if ($this->foto) {
            $path = $this->foto->store('images/user', 'public');
            $fotoPath = '/storage/' . $path;
        }

        // Hitung jumlah admin yang sudah ada (untuk auto-NIP)
        $nipAdmin = null;
        if ($this->isAdmin) {
            $nipAdmin = DB::table('pengguna')
                ->where('level', 'admin')
                ->count() + 1;
        }

        // Tetapkan status otomatis
        $status = $this->isAdmin ? 'green' : 'gray';

        DB::table('pengguna')->insert([
            'nip' => $this->isAdmin ? (string) $nipAdmin : $this->nip,
            'nama' => $this->nama,
            'email' => $this->email,
            'no_tlpn' => $this->no_tlpn,
            'foto' => $fotoPath,
            'level' => $this->level,
            'jabatan' => $this->isAdmin ? 'Admin' : $this->jabatan,
            'password' => Hash::make($this->password),
            'password_plaintext' => $this->password,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Reset form
        $this->reset([
            'nip',
            'nama',
            'email',
            'no_tlpn',
            'foto',
            'jabatan',
            'password',
            'password_confirmation',
        ]);

        $this->showAddModal = false;
        session()->flash('message', 'User berhasil ditambahkan.');
    }


    public function resetInput()
    {
        $this->reset([
            'userId',
            'nama',
            'email',
            'jabatan',
            'status',
            'no_tlpn',
            'nip',
            'password',
            'confirm_password',
            'foto',
            'fotoLama',
            'isEdit'
        ]);
    }

    public function deleteUser($id)
    {
        DB::table('pengguna')->where('id', $id)->delete();
    }

    public function exportCsv()
    {
        $users = DB::table('pengguna');

        if ($this->search) {
            $users->where('nama', 'like', '%' . $this->search . '%');
        }

        if ($this->filterJabatan) {
            $users->where('jabatan', 'like', '%' . $this->filterJabatan . '%');
        }

        if ($this->filterStatus) {
            $users->where('status', $this->filterStatus);
        }

        $users = $users->where('level', 'user')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user-list.csv"'
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'nip', 'Nama', 'Email', 'Jabatan', 'Status', 'no_tlpn']);
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->nip,
                    $user->nama,
                    $user->email,
                    $user->jabatan,
                    $user->status,
                    $user->no_tlpn
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    protected function resetForm()
    {
        $this->reset(['userId', 'nama', 'email', 'jabatan', 'status', 'no_tlpn', 'nip']);
    }

    public function render()
    {


        return view('livewire.admin.user-index', [
            'users' => $this->searchUsers(),

            'statusOptions' => $this->statusOptions,
            'jabatanOptions' => $this->jabatanOptions,
        ]);
    }
}
