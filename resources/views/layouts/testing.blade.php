<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  </script>
  <title>@yield('title', 'Dashboard')</title>
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

<body x-data="{ showModal: false }" @keydown.escape.window="showModal = false" class="flex flex-col min-h-screen">


  <!--navbar-->
  <div class="w-full sticky top-0 bg-white z-[99999999]">

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end py-2 px-6 sm:px-6 md:px-14 lg:px-20 xl:px-46 2xl:px-46">
      <a class="hover:underline" href="#">Buku terbaru</a>
      <a class="hover:underline ml-9" href="#">Hubungi kami</a>
    </div>
    @php
    use Illuminate\Support\Facades\DB;
    $userId = session('user_id');
    $user = $userId ? DB::table('pengguna')->where('id', $userId)->first() : null;
    @endphp

    <header class="flex items-center  py-2 px-2 sm:px-6 md:px-10 lg:px-20 xl:px-40">
      <!-- Kiri: Logo + Kategori -->
      <div class="flex items-center flex-shrink-0 mr-2 sm:mr-4 md:mr-4 lg:mr-4 xl:mr-2 gap-4 sm:gap-8 md:gap-12 lg:gap-20 xl:gap-34">

        <div class="w-16 h-12 sm:w-20 sm:h-14 lg:w-24 lg:h-16 flex items-center justify-center">
          <a href="{{ route('user.buku.index') }}">
            <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" src="{{asset('foto/Logo Auriga.png') }}" class="w-full h-full object-contain" />
          </a>

        </div>




        <label
          class="hidden sm:inline font-bold text-sm cursor-pointer"
          @click.prevent="showModal = !showModal">
          Kategori
        </label>
      </div>

      <!-- Kanan: Input + User Info -->
      <div class="flex items-center justify-between w-full relative">
        <!-- Input -->
        <div class="flex-1 min-w-0 border border-black text-sm  focus:outline-none focus:ring-1 focus:ring-green-700 mr-4 sm:mr-6 md:mr-10 lg:mr-29 xl:mr-34">
          @livewire('user.search-navbar')
        </div>



        <!-- User Info -->
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
          <img
            alt="User avatar"
            class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-10 lg:h-10 rounded-full border-red-600 object-cover"
            src="{{asset('foto/pp.jpeg') }}" />


          <p class="font-bold text-sm sm:flex pr-3 hidden">
            Hi,
            <span>Pengguna</span>
          </p>

          <!-- Panah hanya untuk mobile -->
          <p class="font-bold text-sm sm:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
              <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
          </p>

          <!-- Dropdown -->
          <div
            x-show="dropdownOpen"
            @click.away="dropdownOpen = false"
            class="absolute right-0 top-full mt-2 w-34 bg-white border border-gray-300 z-50 shadow-md"
            x-transition>


            <a href="{{ route('user.buku.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Buku</a>

            <a href="{{ route('user.peminjaman.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Riwayat</a>

            <form id="logout-form" method="POST" action="{{ route('user.logout') }}">
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
    </header>


    <!-- Navigation -->
    <div class="flex justify-center">
      <header

        class="hidden lg:flex justify-center -translate-y-6">
        <nav class="flex justify-center lg:gap-[1.6rem] 2xl:gap-[1.8rem] text-[13px] text-black w-full">
          <a class="hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hutan</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 2)}}">Kebun</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 3)}}">Tambang & Energi</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 4)}}">Laut</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 5)}}">Hukum</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 6)}}">Keuangan</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 7)}}">Novel</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 8)}}">Lainnya</a>
        </nav>
      </header>
    </div>

    <div class="border-b border-red-500 -mt-2 sm:-mt-3 md:-mt-1"></div>
  </div>

  <!-- Modal -->
  <div
    x-show="showModal"
    x-transition
    x-cloak
    @click.self="showModal = false"
    class="fixed inset-0 z-[199999999] flex items-start justify-center pt-24 px-4 sm:px-6 md:px-60 lg:px-82 xl:px-114">
    <div class="bg-white border border-gray-300 shadow-lg w-full 
              px-4 sm:px-6 md:p-8 lg:p-6 xl:p-6">
      <div class="flex flex-col space-y-6">

        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hutan</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 2)}}">Kebun</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 3)}}">Tambang dan Energi</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 4)}}">Laut</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 5)}}">Hukum</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 6)}}">Keuangan</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 7)}}">Novel</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 8)}}">Lainnya</a>
      </div>
    </div>
  </div>
  <!--navbar-->


  <!--content-->


  <div class="flex-1">
    @yield('content')
  </div>



  <!--footer-->
  <footer class="border-t border-red-600 mt-auto bg-white poppins-regular">
    <div class="flex flex-col items-center sm:flex-row sm:items-start justify-between px-4 sm:px-8 md:px-12 lg:px-20 xl:px-44 py-4 border-b-2 gap-4">


      <!-- Logo -->
      <div class="w-16 h-12 sm:w-20 sm:h-14 lg:w-24 lg:h-16">
        <a href="{{ route('user.buku.index') }}">
          <img src="{{ asset('foto/Logo Auriga.png') }}" alt="Logo Auriga" class="w-full h-full object-contain" />
        </a>
      </div>

      <!-- Teks Tengah -->
      <div class="text-sm text-center sm:text-left sm:flex-1 px-4 lg:px-32">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore commodi amet mollitia sapiente, tempora ex dignissimos, ea, nihil at eveniet ipsum debitis accusamus provident unde magnam laboriosam illum perferendis repudiandae!
      </div>

      <!-- Tombol -->
      <!-- Tombol Donasi Buku -->
      <div x-data="{ showModal: false }">
        <button
          @click="showModal = true"
          class="bg-[#1a3a05] text-white px-6 py-2 hover:bg-green-700 transition duration-300 text-xs mr-4">
          Donasi Buku
        </button>

        <!-- Modal -->
        <div
          x-show="showModal"
          class="fixed inset-0  flex items-center justify-center z-50">
          <div class="bg-white p-6 shadow-md w-240 relative">
            <button @click="showModal = false" class="absolute top-2 right-3 text-gray-600 hover:text-black">
              ✕
            </button>
            <h2 class="text-lg font-bold mb-4 text-center">Pilih Metode Donasi</h2>

            <div class="space-y-3">
              <!-- Email -->
              <a href="#" class="flex items-center justify-center gap-2 bg-blue-600 text-white py-2   hover:bg-blue-700 transition">
                <svg width="20px" height="20px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 11.9556C2 8.47078 2 6.7284 2.67818 5.39739C3.27473 4.22661 4.22661 3.27473 5.39739 2.67818C6.7284 2 8.47078 2 11.9556 2H20.0444C23.5292 2 25.2716 2 26.6026 2.67818C27.7734 3.27473 28.7253 4.22661 29.3218 5.39739C30 6.7284 30 8.47078 30 11.9556V20.0444C30 23.5292 30 25.2716 29.3218 26.6026C28.7253 27.7734 27.7734 28.7253 26.6026 29.3218C25.2716 30 23.5292 30 20.0444 30H11.9556C8.47078 30 6.7284 30 5.39739 29.3218C4.22661 28.7253 3.27473 27.7734 2.67818 26.6026C2 25.2716 2 23.5292 2 20.0444V11.9556Z" fill="white" />
                  <path d="M22.0515 8.52295L16.0644 13.1954L9.94043 8.52295V8.52421L9.94783 8.53053V15.0732L15.9954 19.8466L22.0515 15.2575V8.52295Z" fill="#EA4335" />
                  <path d="M23.6231 7.38639L22.0508 8.52292V15.2575L26.9983 11.459V9.17074C26.9983 9.17074 26.3978 5.90258 23.6231 7.38639Z" fill="#FBBC05" />
                  <path d="M22.0508 15.2575V23.9924H25.8428C25.8428 23.9924 26.9219 23.8813 26.9995 22.6513V11.459L22.0508 15.2575Z" fill="#34A853" />
                  <path d="M9.94811 24.0001V15.0732L9.94043 15.0669L9.94811 24.0001Z" fill="#C5221F" />
                  <path d="M9.94014 8.52404L8.37646 7.39382C5.60179 5.91001 5 9.17692 5 9.17692V11.4651L9.94014 15.0667V8.52404Z" fill="#C5221F" />
                  <path d="M9.94043 8.52441V15.0671L9.94811 15.0734V8.53073L9.94043 8.52441Z" fill="#C5221F" />
                  <path d="M5 11.4668V22.6591C5.07646 23.8904 6.15673 24.0003 6.15673 24.0003H9.94877L9.94014 15.0671L5 11.4668Z" fill="#4285F4" />
                </svg>
                Email
              </a>

              <!-- WhatsApp -->
              <a href="#" target="_blank" class="flex items-center justify-center gap-2 bg-green-500 text-white py-2   hover:bg-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                  <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                </svg>WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Copyright -->
    <div class="text-center text-[11px] sm:text-[12px] md:text-[11px] lg:text-[12px] xl:text-[9px] text-black py-2 select-none">
      © 2025 <a href="https://auriga.or.id" class="hover:text-auriga font-semibold">AURIGA NUSANTARA</a>. SELURUH HAK CIPTA DILINDUNGI UNDANG-UNDANG.
    </div>

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end px-6 sm:px-36 py-2">
      <!-- Kosong atau tambahkan info lain -->
    </div>
  </footer>


  @livewireScripts
</body>

</html>
