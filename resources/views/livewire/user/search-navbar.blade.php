    <div class="relative w-full ">

        <!-- Input -->
        <form wire:submit.prevent="search">
            <input
                wire:model.live.debounce.1000ms="query"
                type="text"
                placeholder="Cari buku atau kategori..."
                class="w-full border border-black text-sm py-1 px-2 focus:outline-none focus:ring-1 focus:ring-green-700" />
        </form>

        <!-- Dropdown -->
        @if (!empty($query) && !empty($results))
        <div class="absolute mt-2 w-full bg-white z-50 border shadow ">
            @forelse ($results as $buku)
            <div class="flex items-center w-full text-sm py-1 px-2 hover:bg-gray-100 cursor-pointer w-full"
                wire:click="goToBuku({{ $buku->id }})">

                <!-- Kotak gambar tetap -->
                <div class="w-12 h-12 flex-shrink-0 bg-gray-100 overflow-hidden mr-2">
                    <img src="{{ $buku->foto_buku ?? asset('images/placeholder.png') }}"
                        alt="{{ $buku->nama_buku }}"
                        class="w-full h-full object-cover" />
                </div>

                <!-- Judul buku -->
                <div class="truncate">
                    {{ $buku->nama_buku }}
                </div>
            </div>

            @empty
            <div class="w-full text-sm py-1 px-2 text-gray-500 italic">
                Buku tidak ditemukan
            </div>
            @endforelse
        </div>
        @endif
        <script>
            window.addEventListener('redirectTo', event => {
                window.location.href = event.detail.url;
            });
        </script>
    </div>
