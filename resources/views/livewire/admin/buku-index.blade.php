<div class="container mx-auto px-4  py-4">
    <div class="w-full max-w-6xl mx-auto bg-white  border broder-gray-400 shadow-md overflow-hidden p-4">
        @if (session()->has('message'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="mb-4 p-4   bg-green-100 text-green-800 border border-green-300 flex justify-between items-center">
            <span>{{ session('message') }}</span>
            <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
            <h1 class="text-2xl font-bold">Katalog Buku</h1>

            <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2">
                <a href="buku/create"
                    class="bg-blue-500 text-white px-3 py-1.5 text-sm hover:bg-blue-600 w-full sm:w-auto sm:min-w-[12rem] text-center">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </a>

                <button wire:click="exportCsv"
                    class="bg-green-500 text-white px-3 py-1.5 text-sm hover:bg-green-600 cursor-pointer w-full sm:w-auto sm:min-w-[12rem] text-center">
                    <i class="fas fa-print mr-1"></i> Print
                </button>

                <a href="{{ url('/admin/buku/kategori') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-3 py-1.5 w-full sm:w-auto sm:min-w-[12rem] text-center">
                    Kelola Kategori Buku
                </a>

                <a href="{{ url('/admin/buku/kategori-buku') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-3 py-1.5 w-full sm:w-auto sm:min-w-[12rem] text-center">
                    Lihat Kategori Buku
                </a>
            </div>
 

        </div>


        <div class="mb-4">
            <input
                wire:model="search"
                type="text"
                placeholder="Cari buku..."
                class="w-full p-2 border border-gray-300   mb-3" />

            <div class="flex flex-wrap gap-4">
                <select wire:model.live.debounce.250ms="kategori" class="p-2 border border-gray-300  ">
                    <option value="">Filter by Genre</option>
                    @foreach ($kategoriList as $id => $kategoriOption)
                    <option value="{{ $id }}">{{ ucfirst($kategoriOption) }}</option>
                    @endforeach
                </select>

                <select wire:model="stok" class="p-2 border border-gray-300  ">
                    <option value="">Filter by Stock</option>
                    <option value="ada">In Stock</option>
                    <option value="habis">Out of Stock</option>
                </select>
            </div>
        </div>

        <div class="hidden md:flex bg-gray-100 text-gray-700 font-semibold text-sm uppercase px-6 py-3 border-b border-gray-200">
            <div class="flex-1">Nama Buku</div>
            <div class="w-24 text-center">Stok</div>
            <div class="w-36 text-center">Perubahan Terakhir</div>
        </div>

        @forelse ($bukus as $buku)
        <a href="{{ url('/admin/buku/' . $buku->id . '/detail') }}"
            tabindex="0"
            role="button"
            class="clickable-book flex flex-col md:flex-row items-start md:items-center border-b border-gray-200 px-6 py-4 transition cursor-pointer focus:outline-none focus:ring-2 focus:ring-black hover:bg-black hover:text-white">
            <div class="w-[100px] h-[141px] overflow-hidden pr-4">
                <img src="{{ $buku->foto_buku }}" alt="Buku" class="object-cover w-full h-full rounded shadow">
            </div>

            <div class="flex-1 text-lg font-medium">{{ $buku->nama_buku }}</div>
            <div class="w-24 text-center font-semibold">
                @if ($buku->stok == 0)
                <span class="text-orange-500">Habis</span>
                @else
                <span class="text-green-600">{{ $buku->stok }}</span>
                @endif
            </div>
            <div class="w-36 text-center text-sm">
                {{ \Carbon\Carbon::parse($buku->updated_at)->format('Y-m-d H:i') }}

            </div>
        </a>
        @empty
        <div class="text-center text-gray-500 py-8">
            Tidak ada buku yang ditemukan.
        </div>
        @endforelse

        <div class="mt-6">
            {{ $bukus->links('pagination.custom') }}
        </div>
    </div>
</div>