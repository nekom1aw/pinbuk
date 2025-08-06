<div class="container mx-auto px-6 lg:px-96 py-6">
    <div class="border border-gray-300 p-6 shadow-lg   bg-white">

        <h2 class="text-2xl font-bold mb-4">Form Pengisian Buku</h2>

        {{-- Loading state --}}
        <div wire:loading wire:target="store" class="text-blue-500 text-sm mb-2">
            Menyimpan data...
        </div>

        <form wire:submit.prevent="store" class="space-y-4">

            {{-- Nama Buku --}}
            <div>
                <label for="namaBuku" class="block text-gray-700 font-bold mb-1">Nama Buku</label>
                <input wire:model="nama_buku" id="namaBuku" type="text"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama buku" />
                @error('nama_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Penulis --}}
            <div>
                <label for="penulis" class="block text-gray-700 font-bold mb-1">Penulis</label>
                <input wire:model="penulis" id="penulis" type="text"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama penulis" />
                @error('penulis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tahun Terbit --}}
            <div>
                <label for="terbit_tahun" class="block text-gray-700 font-bold mb-1">Tahun Terbit</label>
                <input wire:model="terbit_tahun" id="terbit_tahun" type="number"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: 2022" />
                @error('terbit_tahun') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Penerbit --}}
            <div>
                <label for="penerbit" class="block text-gray-700 font-bold mb-1">Penerbit</label>
                <input wire:model="penerbit" id="penerbit" type="text"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama penerbit" />
                @error('penerbit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Ringkasan --}}
            <div>
                <label for="ringkasan" class="block text-gray-700 font-bold mb-1">Ringkasan</label>
                <textarea wire:model="ringkasan" id="ringkasan" rows="4"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan ringkasan buku"></textarea>
                @error('ringkasan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-gray-700 font-bold mb-1">Kategori</label>
                <select wire:model.lazy="kategori" id="kategori"
                    class="w-full border   px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($list_kategori as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Foto Buku --}}
            <div>
                <label for="photoBuku" class="block text-gray-700 font-bold mb-1">Foto Buku</label>
                <input wire:model="foto_buku" type="file" id="photoBuku"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('foto_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Preview Foto Buku --}}
            @if ($foto_buku)
            <div class="mb-3">
                <img src="{{ $foto_buku->temporaryUrl() }}"
                    alt="Preview Buku"
                    class="w-32 h-48 object-cover   mx-auto shadow-md" />
            </div>
            @endif

            {{-- Posisi Gambar --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">Posisi Gambar</label>
                <select wire:model="position_foto"
                    class="w-full p-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="top">Atas</option>
                    <option value="center">Tengah</option>
                    <option value="bottom">Bawah</option>
                </select>
                @error('position_foto') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kondisi --}}
            <div>
                <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi</label>
                <select wire:model="kondisi" id="kondisi"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kondisi --</option>
                    @foreach ($list_kondisi as $k)
                    <option value="{{ $k }}">{{ $k }}</option>
                    @endforeach
                </select>
                @error('kondisi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>

                {{-- Jenis Buku --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Buku</label>
                    <select wire:model.live="jenis_buku" class="w-full p-2 border rounded">
                        <option value="">-- Pilih Jenis Buku --</option>
                        <option value="cetak">Cetak</option>
                        <option value="digital">Digital</option>
                    </select>
                    @error('jenis_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- File PDF muncul jika digital --}}
                @if ($jenis_buku === 'digital')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload File PDF</label>
                    <input type="file" wire:model.live="file" accept="application/pdf"
                        class="w-full p-2 border rounded" />
                   
                </div>
                @endif

            </div>




            {{-- Catatan --}}
            <div>
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea wire:model="catatan" id="catatan" rows="4"
                    class="w-full px-3 py-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tampil --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tampil di Halaman User</label>
                <select wire:model="tampil"
                    class="w-full p-2 border   focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
                @error('tampil') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tags --}}
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags (1 kata per tag)</label>
                <div class="flex flex-wrap gap-2">
                    <div class="flex items-center">
                        <input wire:model="newTag" id="tags" type="text"
                            class="w-full px-3 py-2 border  "
                            placeholder="Masukkan tag" />
                        <button type="button" wire:click="addTag"
                            class="ml-2 bg-blue-500 text-white px-3 py-1  ">Add</button>
                    </div>

                    <div class="flex gap-2 mt-2">
                        @foreach($tags as $tag)
                        <span class="bg-blue-200 text-blue-800 px-3 py-1  ">
                            {{ $tag }}
                            <button type="button" wire:click="removeTag('{{ $tag }}')" class="text-red-500 ml-2">×</button>
                        </span>
                        @endforeach
                    </div>
                </div>
                @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex flex-col gap-3 mt-4">
                <button type="submit"
                    class="bg-blue-500 text-white py-2   hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Submit
                </button>
                <a href="{{ url('/admin/buku/') }}"
                    class="bg-gray-500 text-white py-2   text-center hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>