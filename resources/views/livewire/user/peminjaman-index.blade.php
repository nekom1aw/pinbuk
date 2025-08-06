<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="bg-white py-6 font-sans px-6 sm:px-48 space-y-6 ">
        @forelse ($peminjamanList as $item)
        @php
        $statusLabel = [
        'request' => ['bg' => 'bg-yellow-400', 'text' => 'text-yellow-900', 'label' => 'Request'],
        'silahkan di ambil' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Silahkan diambil'],
        'dipinjam' => ['bg' => 'bg-blue-400', 'text' => 'text-white', 'label' => 'Dipinjam'],
        'kembali' => ['bg' => 'bg-green-400', 'text' => 'text-green-900', 'label' => 'Selesai'],
        'jatuh tempo' => ['bg' => 'bg-red-400', 'text' => 'text-red-900', 'label' => 'Jatuh Tempo'],
        ];
        $status = strtolower($item->status);
        $statusInfo = $statusLabel[$status] ?? $statusLabel['dipinjam'];
        @endphp

        <div class="border border-gray-200  p-4 shadow-sm flex flex-col space-y-4">
            <div class="flex flex-wrap items-center space-x-2 text-gray-900 font-semibold">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span>{{ ucfirst($item->status) }}</span>

                <span class="text-gray-700 font-normal">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</span>
                <span class="ml-2 {{ $statusInfo['bg'] }} {{ $statusInfo['text'] }} font-semibold text-[10px] px-2 py-[2px] ">
                    {{ ucfirst($statusInfo['label']) }}
                </span>
                {{--
                <span class="text-gray-600 font-normal ml-2 break-all">
                    {{ $item->jenis }}
                </span>
                --}}

            </div>

            {{--
            <div class="flex items-center space-x-2 text-gray-900 font-semibold text-[14px]">
                <i class="fas {{ strpos($item->kode_uniq, 'B') === 0 ? 'fa-book text-green-700' : 'fa-cogs text-blue-700' }}"></i>
            <span>{{ strpos($item->kode_uniq, 'B') === 0 ? 'Buku' : 'Aset' }}</span>
        </div>
        --}}



        <div class="flex justify-between items-center flex-wrap">
            <div class="flex items-center space-x-3 flex-1 min-w-0">
                <img
                    alt="Gambar barang"
                    class="w-[60px] h-[60px]  object-contain flex-shrink-0"
                    src="{{ $item->gambar }}"
                    width="60"
                    height="60" />
                <div class="min-w-0">
                    <h3 class="font-bold text-[14px] leading-tight max-w-[280px] truncate">
                        {{ $item->nama ?? 'Nama Tidak Ada' }}
                    </h3>

                    <p class="text-[12px] text-gray-700 font-normal mt-1 min-h-[18px]">
                        {{--
                                @if ($item->harga_sewa)
                                1 barang x Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                        @else
                        &nbsp;
                        @endif
                        --}}
                    </p>

                </div>

            </div>


        </div>


        <div x-data="{ showModal: false }">
            <!-- Tombol untuk buka modal -->
            <div class="flex justify-end items-center space-x-3">
                <button @click="showModal = true" class="text-green-700 font-semibold text-[13px] hover:underline" type="button">
                    Lihat Detail Peminjaman
                </button>
            </div>

            <!-- Modal -->
            <div
                x-show="showModal"
                x-transition
                x-cloak
                class="fixed inset-0 z-50 grid place-items-center">

                {{-- Backdrop --}}
                <div class="absolute inset-0" @click="showModal = false" aria-hidden="true"></div>

                {{-- Dialog --}}
                <div class="relative w-full max-w-4xl bg-white border border-gray-900  shadow-lg overflow-hidden">


                    {{-- Header --}}
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Detail Peminjaman Buku</h2>
                        <button @click="showModal = false" aria-label="Close" class="text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="flex flex-col lg:flex-row max-h-[90vh]">
                        {{-- Left column (scrollable) --}}
                        <div class="flex-1 border-b lg:border-b-0 lg:border-r border-gray-200 overflow-y-auto max-h-[90vh]">

                            {{-- Detail Buku --}}
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-sm mb-4">Detail Buku</h3>
                                <div class="flex gap-4 items-center">
                                    <div class="w-[70px] h-[100px] bg-gray-100 flex items-center justify-center">
                                        <img
                                            alt="Cover Buku"
                                            src="{{ $item->gambar }}"
                                            class="object-contain w-full h-full" />
                                    </div>


                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm leading-tight">
                                            {{ $item->nama ?? 'Tidak Ada Nama' }}
                                        </p>

                                    </div>
                                </div>
                            </div>

                            {{-- Info Peminjaman --}}
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-sm mb-4">Info Peminjaman</h3>
                                <dl class="text-xs text-gray-600 space-y-2">
                                    <div class="grid grid-cols-[9rem_1rem_1fr]">
                                        <dt class="text-left font-medium">Peminjam</dt>
                                        <dd>:</dd>
                                        <dd class="text-gray-800">{{ $item->nama_peminjam ?? 'Tidak diketahui' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[9rem_1rem_1fr]">
                                        <dt class="text-left font-medium">Peminjam</dt>
                                        <dd>:</dd>
                                        <dd class="text-gray-800">{{ $item->status?? 'Tidak diketahui' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[9rem_1rem_1fr]">
                                        <dt class="text-left font-medium">Tanggal Pinjam</dt>
                                        <dd>:</dd>
                                        <dd class="text-gray-800">
                                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                        </dd>
                                    </div>
                                    <div class="grid grid-cols-[9rem_1rem_1fr]">
                                        <dt class="text-left font-medium">Tanggal Kembali</dt>
                                        <dd>:</dd>
                                        <dd class="text-gray-800">
                                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                        </div>

                        {{-- Right column --}}
                        @if(in_array(strtolower($item->status), ['jatuh tempo', 'kembali']))
                        <div class="w-full lg:w-80 flex flex-col items-start p-6 bg-gradient-to-b from-[#e9f9f3] to-white space-y-3">

                            {{-- Tombol Perpanjang jika status = jatuh tempo --}}
                            @if(strtolower($item->status) === 'jatuh tempo')
                            <button
                                wire:click="perpanjang({{ $item->id }})"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 ">
                                Perpanjang
                            </button>
                            @endif


                            {{-- Tombol Pinjam Lagi jika status = kembali --}}
                            @if(strtolower($item->status) === 'kembali' && $item->jenis === 'Buku' && $item->buku_id)
                            <a href="{{ route('user.buku.detail', $item->buku_id) }}"
                                class="w-full border border-gray-300 py-3 text-gray-700 font-semibold hover:bg-gray-50  text-center block">
                                Pinjam Lagi
                            </a>
                            @endif



                        </div>
                        @endif


                    </div>
                </div>
            </div>

        </div>


        {{-- Status Timeline --}}
        @php
        $steps = ['Request', 'Silahkan di Ambil', 'Dipinjam', 'Kembali'];
        $currentIndex = collect($steps)
        ->map(fn($s) => strtolower($s))
        ->search(strtolower($item->status));

        @endphp

        @php
        $statusLower = strtolower($status);
        @endphp

        @if ($statusLower === 'jatuh tempo')
        <div class="mt-2 bg-red-600 text-white font-semibold text-center p-3  shadow-md">
            <i class="fas fa-exclamation-triangle mr-2"></i> Jatuh Tempo
        </div>
        @else
        @php
        $steps = ['request', 'silahkan di ambil', 'dipinjam', 'kembali'];
        $currentIndex = array_search($statusLower, array_map('strtolower', $steps));
        @endphp

        <div class="status-menu mt-2 border border-gray-300 bg-white shadow-md p-3 flex items-center justify-between text-sm text-gray-800">
            @foreach ($steps as $index => $step)
            @php
            $isCurrent = $index === $currentIndex;
            $isPast = $index < $currentIndex;
                $textColor=($isPast || $isCurrent) ? 'text-green-600' : 'text-gray-400' ;
                @endphp

                <div class="flex flex-col items-center justify-center w-14 h-14 font-semibold {{ $textColor }}">
                <i class="fas 
                    @if(strtolower($step) === 'request') fa-file-alt
                    @elseif(strtolower($step) === 'silahkan di ambil') fa-hand-paper
                    @elseif(strtolower($step) === 'dipinjam') fa-box-open
                    @elseif(strtolower($step) === 'kembali') fa-undo-alt
                    @endif text-xl mb-1">
                </i>
                <span class="text-xs text-center leading-tight break-words w-full">{{ ucwords($step) }}</span>
        </div>

        @if (!$loop->last)
        <div class="flex-1 h-0.5 {{ $index < $currentIndex ? 'bg-green-600' : 'bg-gray-300' }} mx-2"></div>
        @endif
        @endforeach
    </div>
    @endif


</div>
@empty
<div class="text-sm text-gray-600">Kamu belum meminjam apa pun.</div>
@endforelse
</div>
</div>