<div>
  {{-- The whole world belongs to you. --}}
  <div class="px-4 sm:px-12 md:px-12 lg:px-18 lg:px-24 xl:px-42 2xl:px-42 py-6">
    <h2 class="text-xl font-bold mb-4">{{ $namaKategori }}</h2>

    @if ($buku->isEmpty())
    <div class="text-gray-500 text-sm px-4 py-6">
      Tidak ada buku yang tersedia.
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  2xl:grid-cols-5 gap-12 sm:gap-2 md:gap-4 lg:gap-8  xl:gap-12 2xl:gap-12">

      @foreach ($buku as $bukus)
      @php
      $objectClass = match($bukus->position_foto ?? 'center') {
      'top' => 'object-top',
      'bottom' => 'object-bottom',
      default => 'object-center'
      };
      $foto = $bukus->foto_buku ? asset($bukus->foto_buku) : asset('images/placeholder.png');
      @endphp

      <a
        href="{{ $bukus->total_stok < 1 ? '#' : url('/user/buku/' . $bukus->id . '/detail') }}"
        class="aspect-square flex flex-col border bg-white transition-transform duration-200 sm:w-48 sm:h-48 w-full h-auto
    {{ $bukus->total_stok < 1 
        ? 'pointer-events-none opacity-70 cursor-not-allowed border-gray-200 hover:shadow-md'
        : 'hover:scale-105 hover:border-green-500 hover:shadow-md border-abu' }}"
        aria-disabled="{{ $bukus->total_stok < 1 ? 'true' : 'false' }}">

        <!-- Judul & Ringkasan -->
        <div class="p-2 min-h-[72px]">
          <p class="font-semibold text-xs break-words whitespace-normal leading-snug line-clamp-2">
            {{ $bukus->nama_buku }}
          </p>
          <p class="text-[10px] text-gray-600 leading-tight line-clamp-2">
            {{ $bukus->ringkasan }}
          </p>
        </div>

        <!-- Gambar -->
        <div class="flex-1 bg-gray-600 w-full flex items-center justify-center overflow-hidden">
          <img
            src="{{ $foto }}"
            alt="{{ $bukus->nama_buku }}"
            class="w-full h-full object-cover {{ match($bukus->position_foto ?? 'center') {
        'top' => 'object-top',
        'bottom' => 'object-bottom',
        default => 'object-center'
      } }}" />
        </div>
      </a>

      @endforeach
    </div>
  </div>
  @endif

</div>

</div>
