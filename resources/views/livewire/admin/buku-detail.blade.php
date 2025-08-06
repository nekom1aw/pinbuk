<div class="flex flex-col">
    <div class="flex-grow container mx-auto px-4 px-6 sm:px-10 md:px-20 lg:px-40">
        <div class="flex flex-col items-start py-6 mt-10 px-6 border border-gray-100 shadow-sm rounded-md">

            <div class="flex flex-col lg:flex-row gap-6 items-start">
                <!-- Book Cover -->
                <div class="p-3 w-[280px] h-[397px] flex items-center justify-center mx-auto border">
                    <img src="{{ $buku->foto_buku ?? asset('images/placeholder.png') }}"
                        alt="Judul Buku"
                        class="max-w-full max-h-full object-contain" />
                </div>

                <!-- Konten kanan -->
                <div class="flex flex-col justify-between flex-1 min-h-[397px]">

                    <!-- Bagian Atas: Judul & Ringkasan -->
                    <div>
                        <p class="font-bold text-md pt-2 sm:pt-0 lg:pr-102 lg:mb-1 mb-2">
                            {{ $buku->nama_buku }}
                        </p>


                        <div
                            x-data="{ expanded: false, showToggle: false }"
                            x-init="$nextTick(() => { showToggle = $refs.ringkasan.scrollHeight > $refs.ringkasan.clientHeight })">
                            <div x-ref="ringkasan"
                                class="transition-all space-y-3 overflow-hidden text-xs  lg:mr-70 sm:max-w-[40rem]"
                                :class="{ 'line-clamp-5': !expanded }">
                                {!! $buku->ringkasan !!}
                            </div>
                            <button x-show="showToggle"
                                class="text-blue-500 hover:underline mt-1"
                                @click="expanded = !expanded">
                                <span x-show="!expanded">Read More</span>
                                <span x-show="expanded">Read Less</span>
                            </button>
                        </div>
                    </div>

                    <!-- Bagian Bawah: Info & Tombol -->
                    <div class="mt-4 space-y-1">
                        <!-- Info Buku -->
                        <div class="text-xs opacity-90">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2">

                                <!-- Kolom Kiri -->
                                <div class="space-y-1">
                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Penulis</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1 break-words whitespace-pre-wrap">{{ $buku->penulis ?? '-' }}</div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Tahun Terbit</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1">{{ $buku->terbit_tahun ?? '-' }}</div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Penerbit</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1 break-words whitespace-pre-wrap">{{ $buku->penerbit ?? '-' }}</div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Stok</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1">{{ $buku->stok ?? '-' }}</div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="space-y-1 sm:pl-4">
                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Kondisi</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1">{{ $buku->kondisi ?? '-' }}</div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Kategori</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1">{{ $buku->kategori_nama ?? '-' }}</div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Tags</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1">
                                            @if(is_array($buku->tags))
                                            {{ implode(', ', $buku->tags) }}
                                            @else
                                            {{ $buku->tags ?? '-' }}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="min-w-[100px] pr-2 font-medium">Stok</div>
                                        <div class="pr-1">:</div>
                                        <div class="flex-1">{{ $buku->jenis_buku ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <a href="{{ url('/admin/buku/' . $buku->id . '/pinjam') }}">
                            <button class="bg-indigo-700 hover:bg-indigo-800 mt-2 font-bold text-sm px-4 py-2 w-32 transition text-white 
        @if($buku->stok == 0) opacity-50 cursor-not-allowed @endif"
                                @if($buku->stok == 0) disabled @endif>
                                Pinjam Buku
                            </button>
                        </a>

                        <a onclick="window.open('{{ url('/storage/qr_codes/buku/qr_' . $buku->id . '.png') }}').print()">
                            <button class="border border-indigo-700 hover:bg-indigo-100 mt-2 font-bold text-sm px-4 py-2 w-32 transition text-indigo-700">
                                Cetak QR
                            </button>
                        </a>

                        <a href="{{ url('/admin/buku/' . $buku->id . '/edit') }}">
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white mt-2 font-bold text-sm px-4 py-2 w-32 transition">
                                Edit
                            </button>
                        </a>

                        <a>
                            <button wire:click="confirmDelete"
                                class="bg-red-500 hover:bg-red-600 text-white mt-2 font-bold text-sm px-4 py-2 w-32 transition">
                                Hapus
                            </button>
                        </a>

                        <a href="{{ url('/admin/buku/' . $buku->id . '/view') }}">
                            <button class="bg-gray-500 hover:bg-gray-600 text-white mt-2 font-bold text-sm px-4 py-2 w-32 transition">
                                Detail Buku
                            </button>
                        </a>



                    </div>
                    @if ($confirmingDelete)
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
                            <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
                            <p>Apakah kamu yakin ingin menghapus buku <strong>{{ $buku->nama_buku }}</strong>?</p>
                            <div class="mt-6 flex justify-end space-x-4">
                                <button wire:click="$set('confirmingDelete', false)"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                    Batal
                                </button>
                                <button wire:click="deleteBuku"
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Buku Sedang Dipinjam --}}
    <div class="max-w-5xl mx-auto mt-10 bg-white shadow-md p-6 border mb-10">
        <h3 class="text-xl font-semibold text-gray-500 mb-4">Sedang Dipinjam</h3>

        @if(count($peminjamanAktif) > 0)
        <ul class="space-y-4">
            @foreach ($peminjamanAktif as $pinjam)
            <a href="{{ url('/admin/peminjaman/' . $pinjam->id . '/detail') }}" class="block">
                <li class="border p-4  bg-yellow-50 shadow-sm hover:bg-yellow-100 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-800"><strong>Nama Peminjam:</strong> {{ $pinjam->nama_peminjam ?? '-' }}</p>
                            <p class="text-gray-600"><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->translatedFormat('d F Y') }}</p>
                            <p class="text-gray-600"><strong>Kode Unik:</strong> {{ $pinjam->kode_uniq }}</p>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-700  text-sm font-medium">
                            {{ $pinjam->status }}
                        </span>
                    </div>
                </li>
            </a>
            @endforeach
        </ul>
        @else
        <p class="text-red-500 italic">Belum ada peminjaman aktif untuk buku ini.</p>
        @endif
    </div>


</div>