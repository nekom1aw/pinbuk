<div x-data="{
    modalOpen: @entangle('showModal'),
    users: @entangle('users').defer,
    selectedUser: null,
    confirmDeleteOpen: false,
    deleteId: null
}" x-cloak>

    <div class="w-full max-w-[75vw] bg-white border shadow-md p-6 mx-auto my-8">
        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4">
            <a wire:click="showAddForm"
                class="bg-blue-500 text-white min-w-[120px] h-10 text-sm sm:text-base rounded hover:bg-blue-600 transition cursor-pointer flex items-center justify-center text-center">
                Tambah User
            </a>

            <a wire:click="showAddAdminForm"
                class="bg-purple-600 text-white min-w-[120px] h-10 text-sm sm:text-base rounded hover:bg-purple-700 transition cursor-pointer flex items-center justify-center text-center">
                Tambah Admin
            </a>

            <a wire:click="exportCsv"
                class="bg-green-500 text-white min-w-[120px] h-10 text-sm sm:text-base rounded hover:bg-green-600 transition cursor-pointer flex items-center justify-center text-center">
                <i class="fas fa-print"></i> Print
            </a>
        </div>

        <h1 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Daftar User</h1>

        <div class="space-y-4">
            @foreach ($users as $index => $user)
            <div class="flex flex-col sm:flex-row sm:items-center bg-gray-100 rounded-lg p-4">
                <div class="flex-shrink-0 text-gray-700 font-semibold text-lg sm:w-8 sm:text-center mb-2 sm:mb-0">
                    {{ $loop->iteration }}
                </div>
                <div class="flex-shrink-0 mx-auto sm:mx-0">
                    <img
                        src="{{ $user->foto }}"
                        class="h-16 w-16 rounded-full object-cover border-4 
                        @if($user->status === 'gray') border-gray-400 
                        @elseif($user->status === 'green') border-auriga 
                        @elseif($user->status === 'yellow') border-orange-500 
                        @elseif($user->status === 'red') border-red-800 
                        @elseif($user->status === 'black') border-gray-800 
                        @else border-gray-300 @endif" />

                </div>
                <div class="mt-2 sm:mt-0 sm:ml-4 flex-1 text-center sm:text-left">
                    <div class="text-gray-900 font-medium text-lg truncate">{{ $user->nama }}</div>
                    <div class="text-gray-600 text-lg truncate">{{ $user->email }}</div>
                </div>
                <div class="mt-2 sm:mt-0 sm:ml-4 flex space-x-2 justify-center sm:justify-end sm:w-24">
                    <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-800 font-semibold text-lg">
                        Edit
                    </button>
                    <button @click="confirmDeleteOpen = true; deleteId = {{ $user->id }}" class="text-red-600 hover:text-red-800 font-semibold text-lg">
                        Hapus
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    @if($showAddModal)
    <div class="fixed inset-0 overflow-y-auto z-50 bg-gray-100 bg-opacity-40">
        <div class="flex items-start justify-center min-h-screen pt-10 px-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative"
                wire:click.away="$set('showAddModal', false)">
                <h2 class="text-xl font-semibold mb-6 text-gray-900">Tambah User</h2>

                {{-- Toggle admin --}}


                <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Nama</label>
                        <input type="text" wire:model.defer="nama"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500" required />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Email</label>
                        <input type="email" wire:model.defer="email"
                            class="w-full border border-gray-300 rounded px-3 py-2" required />
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Telepon</label>
                        <input type="text" wire:model.defer="no_tlpn"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>

                    {{-- Hanya untuk user biasa --}}
                    @if (!$isAdmin)
                    {{-- Jabatan --}}
                    <div>
                        <label for="jabatan" class="block text-gray-700 font-medium mb-1">Jabatan</label>
                        <select wire:model="jabatan" id="jabatan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <optgroup label="Pimpinan">
                                <option value="Ketua Yayasan">Ketua Yayasan</option>
                                <option value="Deputi Kelembagaan">Deputi Kelembagaan</option>
                                <option value="PJ Direktur Kehutanan">PJ Direktur Kehutanan</option>
                                <option value="Direktur Informasi dan Data">Direktur Informasi dan Data</option>
                                <option value="Monitoring dan Evaluasi">Monitoring dan Evaluasi</option>
                                <option value="Direktur Penegak Hukum">Direktur Penegak Hukum</option>
                                <option value="Direktur Komunikasi dan Advokasi">Direktur Komunikasi dan Advokasi</option>
                                <option value="Direktur Perkebunan">Direktur Perkebunan</option>
                                <option value="Direktur Tambang dan Energi">Direktur Tambang dan Energi</option>
                            </optgroup>
                            <optgroup label="Staf Direktorat">
                                <option value="Staf Direktorat Kehutanan">Staf Direktorat Kehutanan</option>
                                <option value="Staf Direktorat Informasi dan Data">Staf Direktorat Informasi dan Data</option>
                                <option value="Staf Direktorat Penegakan Hukum">Staf Direktorat Penegakan Hukum</option>
                                <option value="Staf Direktorat Komunikasi dan Advokasi">Staf Direktorat Komunikasi dan Advokasi</option>
                                <option value="Staf Direktorat Perkebunan">Staf Direktorat Perkebunan</option>
                                <option value="Staf Direktorat Tambang dan Energi">Staf Direktorat Tambang dan Energi</option>
                            </optgroup>
                            <optgroup label="Biro">
                                <option value="Biro Administrasi">Administrasi</option>
                                <option value="Biro Keuangan">Keuangan</option>
                                <option value="Biro Kerumahtanggaan">Kerumah Tanggaan</option>
                                <option value="Teknologi dan Informasi">Teknologi dan Informasi</option>
                                <option value="kepala Biro Keuangan">Kepala Biro Keuangan</option>
                                <option value="Staf Keuangan">Staf Keuangan</option>
                            </optgroup>
                        </select>
                    </div>

                    

                    {{-- NIP --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">NIP</label>
                        <input type="text" wire:model.defer="nip"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>
                    @endif

                    {{-- Password --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Password</label>
                        <input type="password" wire:model.defer="password"
                            class="w-full border border-gray-300 rounded px-3 py-2" required />
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                        <input type="password" wire:model.defer="password_confirmation"
                            class="w-full border border-gray-300 rounded px-3 py-2" required />
                    </div>

                    {{-- Foto --}}
                    <div class="md:col-span-2" x-data="{ imagePreview: '' }">
                        <label class="block text-gray-700 font-medium mb-1">Foto</label>

                        <input
                            type="file"
                            wire:model="foto"
                            accept="image/*"
                            @change="imagePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : ''"
                            class="w-full border border-gray-300 rounded px-3 py-2" />

                        @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <!-- Preview langsung via Alpine -->
                        <div x-show="imagePreview" class="mt-2">
                            <img :src="imagePreview" class="w-24 h-24 object-cover rounded-full" />
                        </div>


                    </div>


                    {{-- Tombol --}}
                    <div class="md:col-span-2 flex justify-end space-x-3 mt-4">
                        <button type="button" wire:click="$set('showAddModal', false)"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white font-semibold">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif



    {{-- MODAL EDIT --}}
    @if ($showEditModal)
    <div class="fixed inset-0 overflow-y-auto z-50 bg-black bg-opacity-40">
        <div class="flex items-start justify-center min-h-screen pt-10 px-4">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative"
                @click.away="$wire.set('showEditModal', false)">

                <h2 class="text-xl font-semibold mb-4 text-gray-900">
                    {{ $isEdit ? 'Edit ' . ($isAdmin ? 'Admin' : 'User') : 'Tambah ' . ($isAdmin ? 'Admin' : 'User') }}
                </h2>

                <form wire:submit.prevent="update">
                    {{-- Foto --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Foto Profil</label>

                        {{-- Preview foto baru bila dipilih --}}
                        @if ($foto)
                        <img src="{{ $foto->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-full mb-2" alt="Preview Foto Baru">
                        @elseif ($foto_lama)
                        {{-- Preview foto lama --}}
                        <img src="{{ asset( $foto_lama) }}" class="w-24 h-24 object-cover rounded-full mb-2" alt="Foto Lama">
                        @endif

                        <input type="file" wire:model="foto"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
               file:rounded file:border-0 file:text-sm file:font-semibold
               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    </div>

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Nama</label>
                        <input type="text" wire:model.defer="nama"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Email</label>
                        <input type="email" wire:model.defer="email"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required />
                    </div>


                    {{-- No Telepon --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Telepon</label>
                        <input type="text" wire:model.defer="no_tlpn"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>

                    {{-- Kondisi untuk USER --}}
                    @if (!$isAdmin)
                    {{-- Jabatan --}}
                    <div class="mb-4">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select wire:model="jabatan" id="jabatan"
                            class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                            <option value="">-- Pilih Jabatan --</option>

                            <optgroup label="Pimpinan">
                                <option value="Ketua Yayasan">Ketua Yayasan</option>
                                <option value="Deputi Kelembagaan">Deputi Kelembagaan</option>
                                <option value="PJ Direktur Kehutanan">PJ Direktur Kehutanan</option>
                                <option value="Direktur Informasi dan Data">Direktur Informasi dan Data</option>
                                <option value="Monitoring dan Evaluasi">Monitoring dan Evaluasi</option>
                                <option value="Direktur Penegak Hukum">Direktur Penegak Hukum</option>
                                <option value="Direktur Komunikasi dan Advokasi">Direktur Komunikasi dan Advokasi</option>
                                <option value="Direktur Perkebunan">Direktur Perkebunan</option>
                                <option value="Direktur Tambang dan Energi">Direktur Tambang dan Energi</option>
                            </optgroup>

                            <optgroup label="Staf Direktorat">
                                <option value="Staf Direktorat Kehutanan">Staf Direktorat Kehutanan</option>
                                <option value="Staf Direktorat Informasi dan Data">Staf Direktorat Informasi dan Data</option>
                                <option value="Staf Direktorat Penegakan Hukum">Staf Direktorat Penegakan Hukum</option>
                                <option value="Staf Direktorat Komunikasi dan Advokasi">Staf Direktorat Komunikasi dan Advokasi</option>
                                <option value="Staf Direktorat Perkebunan">Staf Direktorat Perkebunan</option>
                                <option value="Staf Direktorat Tambang dan Energi">Staf Direktorat Tambang dan Energi</option>
                            </optgroup>

                            <optgroup label="Biro">
                                <option value="Biro Administrasi">Administrasi</option>
                                <option value="Biro Keuangan">Keuangan</option>
                                <option value="Biro Kerumahtanggaan">Kerumah Tanggaan</option>
                                <option value="Teknologi dan Informasi">Teknologi dan Informasi</option>
                                <option value="kepala Biro Keuangan">Kepala Biro Keuangan</option>
                                <option value="Staf Keuangan">Staf Keuangan</option>
                            </optgroup>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" id="status"
                            class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="green">Hijau</option>
                            <option value="yellow">Kuning</option>
                            <option value="red">Merah</option>
                            <option value="black">Hitam</option>
                        </select>
                    </div>

                    {{-- NIP --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">NIP</label>
                        <input type="text" wire:model.defer="nip"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>
                    @endif

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Password Baru</label>
                        <input type="password" wire:model.defer="password"
                            class="w-full border border-gray-300 rounded px-3 py-2"
                            placeholder="Biarkan kosong jika tidak ingin mengubah" />
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                        <input type="password" wire:model.defer="password_confirmation"
                            class="w-full border border-gray-300 rounded px-3 py-2"
                            placeholder="Ulangi password baru" />
                    </div>


                    {{-- Tombol --}}
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                            wire:click="$set('showEditModal', false)"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif



    {{-- MODAL KONFIRMASI HAPUS --}}
    <div x-show="confirmDeleteOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="confirmDeleteOpen = false" x-show="confirmDeleteOpen" x-transition.scale class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
            <p class="text-gray-700 mb-6">Apakah kamu yakin ingin menghapus user ini? Tindakan ini tidak bisa dibatalkan.</p>
            <div class="flex justify-end space-x-3">
                <button @click="confirmDeleteOpen = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">
                    Batal
                </button>
                <button
                    @click="$wire.deleteUser(deleteId); confirmDeleteOpen = false"
                    class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>