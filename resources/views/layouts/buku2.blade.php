<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  </script>
  <title>@yield('title', 'Dashboard')</title>
  <link rel="stylesheet" href="/dflip/css/dflip.min.css">
  <script src="/dflip/js/libs/jquery.min.js"></script>
  <script src="/dflip/js/dflip.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;1,100&display=swap');

    p {
      font-family: "Poppins", sans-serif;

      font-style: normal;
    }
  </style>
  @vite('resources/css/app.css')
  @livewireStyles


</head>

<body x-data="{ showModal: false }" @keydown.escape.window="showModal = false" class="flex flex-col m-0 p-0 w-full h-[100dvh] bg-[#FDFDFC] text-[#1b1b18]">

 
  <div class="w-full sticky top-0 bg-white z-99">

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end py-2 px-6 sm:px-6 md:px-10 lg:px-20 xl:px-46">

    </div>
    @php
    use Illuminate\Support\Facades\DB;
    $userId = session('user_id');
    $user = $userId ? DB::table('pengguna')->where('id', $userId)->first() : null;
    @endphp


    <div class="flex items-center py-2 px-2 sm:px-6 md:px-10 lg:px-20 xl:px-40 justify-between">
      <!-- Kiri: Logo + Navigasi -->
      <div class="flex items-center gap-4 sm:gap-8 md:gap-14 lg:gap-20 xl:gap-34">
        <!-- Logo -->
        <div class="w-16 h-12 sm:w-20 sm:h-14 lg:w-24 lg:h-16 flex items-center justify-center">
          <a href="{{ route('admin.admin.users.index') }}">
            <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" src="{{asset('foto/Logo Auriga.png') }}" class="w-full h-full object-contain" />
          </a>
        </div>


      </div>
      <div>
        <div class="flex gap-x-2 ml-10 lg:ml-6 sm:gap-x-2 md:gap-x-6 lg:gap-x-12 xl:gap-x-20 2xl:gap-x-22 text-xs sm:text-xs md:text-sm lg:text-sm xl:text-md 2xl:text-md">
          <a class="hover:font-semibold" href="/admin/users">Pengguna</a>
          <a class="hover:font-semibold" href="/admin/buku">Buku</a>
          <a class="hover:font-semibold" href="/admin/aset">Aset</a>
          <a class="hover:font-semibold" href="/admin/peminjaman">Riwayat</a>
        </div>
      </div>


      <!-- Kanan: Avatar -->
      <div
        x-data="{ dropdownOpen: false, isMobile: false }"
        x-init="
    isMobile = window.innerWidth < 640;
    window.addEventListener('resize', () => {
      isMobile = window.innerWidth < 640;
      if (!isMobile) dropdownOpen = false; // reset dropdown saat pindah layar
    });
  "
        @mouseenter="if(!isMobile) dropdownOpen = true"
        @mouseleave="if(!isMobile) dropdownOpen = false"
        @click="if(isMobile) dropdownOpen = !dropdownOpen"
        @click.away="dropdownOpen = false"
        class="relative flex items-center space-x-2 sm:space-x-2 flex-shrink-0 cursor-pointer select-none sm:mr-0 mr-3 sm:ml-0 ml-auto">
        <!-- Avatar -->
        @if(isset($user))
        <!-- Avatar -->
        @php
        $statusColors = [
        'red' => 'border-red-500',
        'green' => 'border-green-500',
        'yellow' => 'border-yellow-500',
        'black' => 'border-black',
        ];

        $borderClass = $statusColors[$user->status] ?? 'border-gray-400';
        @endphp

        <img
          alt="User avatar"
          class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-10 lg:h-10 rounded-full border-3 {{ $borderClass }} object-cover"
          src="{{ $user->foto}}" />


        <p class="font-bold text-sm sm:flex pr-3 hidden">
          Hi,

          {{ $user->nama }}

        </p>
        @endif

        <!-- Panah hanya untuk mobile -->
        <p class="font-bold text-sm sm:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
          </svg>
        </p>
        <div
          x-show="dropdownOpen"
          @click.away="dropdownOpen = false"
          class="absolute right-0 top-full mt-2 w-34 bg-white border border-gray-300 z-50 shadow-md"
          x-transition>


          <a href="{{ route('admin.admin.users.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Pengguna</a>
          <a href="{{ route('admin.admin.buku.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">buku</a>
          <a href="{{ route('admin.admin.asset.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">aset</a>
          <a href="{{ route('admin.admin.peminjaman.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Riwayat</a>

          <form id="logout-form" method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
          </form>









        </div>


      </div>
    </div>
    <div class="border-b border-red-500 mt-1"></div>
    <!---menu-->

  </div>
  <!--navbar-->


  <!--content-->

  <div>
    @yield('content')
  </div>

  <!--footer-->
  <footer class="border-t border-red-600 mt-auto bg-white poppins-regular">
    <div class="w-full border-b-2 border-black sm:px-6 md:px-10 lg:px-20 xl:px-40 py-6 flex flex-col sm:flex-row justify-between items-start gap-6 sm:gap-4">
      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="{{ route('admin.admin.users.index') }}">
          <img alt="Logo Auriga" src="{{ asset('foto/Logo Auriga.png') }}" class="w-28 sm:w-24 h-auto object-contain" />
        </a>
      </div>

      <!-- Paragraf Tengah -->
      <div class="flex-1 text-[13px] sm:text-[14px] text-black text-left px-30">
        <p class="leading-snug sm:leading-normal font-semibold">
          Diisi dengan tag line Acepellu pturiae molut volora volent, et fuga. Ita earum, tem cullit, nus et, solupta estrum, con corectia cor sequiaspedi alit asincia pliae exero doluptaerume pos aut libus am reres...
        </p>
      </div>

      <!-- Tombol Donasi -->
      <div x-data="{ showModal: false }">

        <!-- Tombol -->
        <div class="flex-shrink-0 mr-6">
          <button @click="showModal = true"
            class="bg-[#1a3a05] hover:bg-green-900 text-white text-xs font-semibold px-8 py-2">
            Donasi Buku:
          </button>
        </div>

        <!-- Modal -->
        <div x-show="showModal"
          class="fixed inset-0 flex items-center justify-center z-50 bg-opacity-50"
          x-transition>
          <div class="bg-white w-full max-w-md  shadow-lg p-6 relative" @click.outside="showModal = false">
            <h2 class="text-lg font-bold mb-4">Form Donasi Buku</h2>

            <!-- Isi Form di sini -->
            <form>
              <input type="text" placeholder="Judul Buku" class="w-full mb-3 border p-2  " />
              <textarea placeholder="Catatan" class="w-full border p-2   mb-3"></textarea>
              <button type="submit" class="bg-green-700 text-white px-4 py-2  ">Kirim</button>
            </form>

            <!-- Tombol Tutup -->
            <button @click="showModal = false"
              class="absolute top-2 right-3 text-gray-700 hover:text-red-500 text-xl">&times;</button>
          </div>
        </div>

      </div>

    </div>

    <!-- Hak Cipta -->
    <div class="text-center text-[11px] sm:text-[12px] md:text-[11px] lg:text-[12px] xl:text-[9px] text-black py-2 select-none">
      © 2025 <a href="https://auriga.or.id" class="hover:text-auriga font-semibold">AURIGA NUSANTARA</a>. SELURUH HAK CIPTA DILINDUNGI UNDANG-UNDANG.
    </div>

    <!-- Bar Hijau Bawah -->
    <div class="bg-[#1a3a05] h-4"></div>
  </footer>
  @livewireScripts
</body>

</html>
