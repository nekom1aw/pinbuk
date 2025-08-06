<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="bg-white" x-data="{ showTerms: false, agreed: false }" @close-modal.window="showTerms = false">

        <div class="flex flex-col items-start px-6 sm:px-10 md:px-20 lg:px-22 xl:px-42 py-4 mt-10">
            <div class="w-full">
                <p class="font-bold text-xs mb-1">
                    {{$buku->nama_kategori}}
                </p>

            </div>

            <div class="flex flex-col lg:flex-row gap-6 items-start">
                <!-- Book Cover -->
                <div class="p-3 w-[280px] h-[397px] flex items-center justify-center mx-auto border">
                    <img src="{{ $buku->foto_buku ?? asset('images/placeholder.png') }}"
                        alt="Judul Buku"
                        class="max-w-full max-h-full object-contain" />
                </div>

                <!-- Konten kanan -->
                <div class="flex flex-col justify-between min-h-[397px] flex-1">
                    <!-- Bagian Atas: Judul & Ringkasan -->
                    <div>
                        <p class="font-bold text-md pt-2 sm:pt-0 pr-12 lg:pr-20 xl:pr-62 lg:mb-1 mb-2">
                            {{ $buku->nama_buku }}
                        </p>


                        <div
                            x-data="{ expanded: false, showToggle: false }"
                            x-init="$nextTick(() => { showToggle = $refs.ringkasan.scrollHeight > $refs.ringkasan.clientHeight })">
                            <div x-ref="ringkasan"
                                class="transition-all space-y-3 overflow-hidden text-sm  lg:mr-70 sm:max-w-[40rem]"
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
                        <div class="text-xs opacity-90 space-y-1">
                            <div class="flex items-start">
                                <div class="min-w-[100px] pr-2 font-medium">Penulis</div>
                                <div class="pr-1">:</div>
                                <div class="flex-1">{{ $buku->penulis ?? '-' }}</div>
                            </div>

                            <div class="flex items-start">
                                <div class="min-w-[100px] pr-2 font-medium">Tahun Terbit</div>
                                <div class="pr-1">:</div>
                                <div class="flex-1">{{ $buku->terbit_tahun ?? '-' }}</div>
                            </div>

                            <div class="flex items-start">
                                <div class="min-w-[100px] pr-2 font-medium">Penerbit</div>
                                <div class="pr-1">:</div>
                                <div class="flex-1">{{ $buku->penerbit ?? '-' }}</div>
                            </div>

                            <div class="flex items-start">
                                <div class="min-w-[100px] pr-2 font-medium">Stok</div>
                                <div class="pr-1">:</div>
                                <div class="flex-1">{{ $buku->total_stok }}</div>
                            </div>
                        </div>


                        @php
                        $cetak = $varianBuku->where('jenis_buku', 'cetak')->where('stok', '>', 0)->first();
                        $digital = $varianBuku->where('jenis_buku', 'digital')->first();
                        @endphp

                        <div class="flex items-center gap-2 mt-2 text-sm font-bold">

                            {{-- Tombol Pinjam --}}
                            @if ($varianBuku->where('jenis_buku', 'cetak')->count() > 0)
                            @if ($cetak && !$sudahDipinjam)
                            <button
                                class="bg-gray-300 px-3 py-2 min-w-[6rem] text-center hover:bg-gray-400 transition"
                                @click="showTerms = true"
                                type="button">
                                Pinjam
                            </button>
                            @elseif ($sudahDipinjam)
                            <button
                                class="bg-gray-200 text-gray-500 px-3 py-2 min-w-[6rem] text-center cursor-not-allowed"
                                type="button"
                                disabled
                                title="Anda sudah meminjam buku ini">
                                Sudah Dipinjam
                            </button>
                            @else
                            <button
                                class="bg-gray-100 text-gray-400 px-3 py-2 min-w-[6rem] text-center cursor-not-allowed"
                                type="button"
                                disabled
                                title="Stok buku cetak habis">
                                Pinjam
                            </button>
                            @endif
                            @else
                            <button
                                class="bg-gray-100 text-gray-400 px-3 py-2 min-w-[6rem] text-center cursor-not-allowed"
                                type="button"
                                disabled
                                title="Buku cetak tidak tersedia">
                                Pinjam
                            </button>
                            @endif

                            {{-- Pemisah | --}}
                            <span class="text-gray-400">|</span>

                            {{-- Tombol Baca Buku --}}
                            @if ($varianBuku->where('jenis_buku', 'digital')->count() > 0)
                            @if ($digital)
                            <a href="{{ url('/user/buku/' . $digital->id . '/view') }}">
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 min-w-[6rem] text-center">
                                    Baca Buku
                                </button>
                            </a>
                            @else
                            <button
                                class="bg-gray-100 text-gray-400 px-3 py-2 min-w-[6rem] text-center cursor-not-allowed"
                                type="button"
                                disabled
                                title="Buku digital tidak tersedia">
                                Baca Buku
                            </button>
                            @endif
                            @else
                            <button
                                class="bg-gray-100 text-gray-400 px-3 py-2 min-w-[6rem] text-center cursor-not-allowed"
                                type="button"
                                disabled
                                title="Buku digital tidak tersedia">
                                Baca Buku
                            </button>
                            @endif

                        </div>



                    </div>
                </div>
            </div>


            <div class="mt-10">
                <p class="font-bold text-xs mb-3">Rekomendasi Buku</p>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-12 sm:gap-2 md:gap-4 lg:gap-8  xl:gap-12 2xl:gap-12">
                    @foreach ($otherBooks as $item)
                    <a href="{{ url('/user/buku/' . $item->id . '/detail') }}"
                        class="bg-white border border-gray-200 shadow-sm flex flex-col hover:scale-105 hover:shadow-md hover:border-green-500 transition sm:w-48 sm:h-48 w-full">

                        {{-- Judul --}}
                        <div class="p-2 min-h-[72px]">
                            <p class="font-semibold text-xs leading-snug line-clamp-3">{{ $item->nama_buku }}</p>
                        </div>

                        {{-- Gambar --}}
                        <div class="flex-1 bg-gray-100 aspect-square overflow-hidden flex items-center justify-center">
                            <img src="{{ $item->foto_buku ?? asset('images/placeholder.png') }}"
                                alt="{{ $item->nama_buku }}"
                                class="w-full h-full object-cover">
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="mt-4 flex justify-end">
                    {{ $otherBooks->links('pagination.custom') }}
                </div>
            </div>


            <!-- Modal -->
            <div
                x-show="showTerms"
                class="fixed inset-0 flex items-center justify-center mt-22 z-[999999999] px-4 sm:px-6 md:px-8 lg:pl-88 lg:pr-[21.9rem]"
                x-cloak>


                <div class="bg-white border px-9 py-6 w-full max-h-[90vh] overflow-y-auto  relative"
                    @click.away="showTerms = false">
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 text-sm mb-4">
                        {{ session('error') }}
                    </div>
                    @endif
                    <h3 class="font-semibold text-md mb-4">Syarat Ketentuan</h3>

                    <p class="sm:text-[10px] text-[9px] leading-tight mb-3">
                        Tambang dan EnergiMusae molest qui beatur atiuntibus aut versper essinci coremo consed quates et aut perume si cusam sant essimus aut alis
                        que comnis ab ipsapeles mint doluptibus moluptate qui doluptu rehendae plaute sameni alit pre cusdantion consequame que nihit ant.
                        Mus, idelendus, coriantis mostior aut autaquis dolut pratem quas reiuribus et ped millaut ut exces nullent reperna temporent minihici ommos
                        moloris millabor aut vent fugia delectus, invent iumendi tibusaperum nis doloreh enimagn ihicil ius ipsa non pro qui abo. Nam ium aci nuscit
                        doluptionse doluptas que si dit quo ent, is evellupis suntur, que nihicil iberemo lupturi tatibus.
                        Quis cora volorpossum quatio molorep ratur?
                    </p>
                    <p class="sm:text-[10px] text-[9px] leading-tight mb-3">
                        Igendit ut quiament, sum si ipis debit eius aut liquissi blatem dolest estia quis ad que atiuntias res endeles dis aut ommolup taquiae dolorerovita cor samet volutas ex eum haris nonsequce occatem. Ur? Apeliqui apitem natiam, tetur sit hit et aliciam, tore magnihii liaspicium el il inum etur? Erio beate nia quistrum nes minvent pre, quis moluptate doluptatquia vent. Udae peror sundis volorita nis most ut verum id et odioritin et, ut evel magniment optae nes etur?
                    </p>
                    <p class="sm:text-[10px] text-[9px] leading-tight mb-3">
                        Ullescia debis rem. Nam, voluptatquam que vidit fugit alitin nos eturero omnimaximus ipsae lisimin ctesistiat dolut in cuscia dolutati iorecerios si bero qui doluptiuntem re suntisi magnis sit resendit oditeces dolum quas doloreporem fugitae. Untur, cum aut aut eationet officia spitiora doluptur assed quo odis ipictiatem que por am aut maio. Andam sitatur remporest qui blabo. Enimporem. Lenis et del ipsanihil mod unt quatas doluptates venis sequam repro bea voluptatant aut etuscit harum et optur sam sum elenissit etur audit, quias venditatur ad ullabo. Itat esti officiument expe estor modi omniniil lanimi, sequis qui te excerspid quae pe mosandae.
                    </p>
                    <p class="sm:text-[10px] text-[9px] leading-tight mb-4">
                        Et repelli taquid mil ipidess itamus erchilicto conminaio. Tes ea si ipsunt latatus sa voluptaeris mi, et optur, ut officiet magnist rumque ditibus et odi nietur sequidi odignissum volectur re ped es dolla ditatus escium arum re quam, ide quo comniscit pa que nisquis quis ex esequat atatate mporeprem fugitae. Et re rsperro maximus cidunt, tem fuga. Et aut pa que non et offic te reperio. Hillore, que exerore rferum eum eos sectibust fugitiaest dolorpo reprae vendita tiundus dolorrum lique vellige ndistoria volorem elest parum ipsanditam nem fuga. Et ex eum quate nem fuga. Nem fugiaes mi, quaecep eraectur aliquuntiae conem imus et maximus dandunti odipiet everrum doluptur riamet essitat occaborest, occulpa pro ium id mintio. Borrum laborro iniminc ipienti sincti doluptas essimpedis eum hilibea dolorepta quossit inveror maioria ssedipicae quationseque nus evel eium sit es porero di vellaut dellupt atectis vel maioratur?
                    </p>

                    <!-- Checkbox and button -->
                    <div class="flex items-center mb-14">
                        <input type="checkbox" class="form-checkbox w-5 h-5 text-black border-gray-400"
                            x-model="agreed" />
                        <span class="ml-2 text-sm font-bold select-none">Setuju</span>


                    </div>

                    <!-- Button -->
                    <div class="flex mb-4">
                        <button
                            type="button"
                            wire:click="pinjamBuku"
                            wire:loading.attr="disabled"
                            :disabled="!agreed"
                            class="font-bold text-sm px-2 py-1 transition"
                            :class="agreed 
  ? 'bg-gray-300 hover:bg-gray-400 cursor-pointer' 
  : 'bg-gray-500 text-white cursor-not-allowed'">
                            Pinjam
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


</div>