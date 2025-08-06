<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <!-- DearFlip -->
  <link rel="stylesheet" href="/dflip/css/dflip.min.css">
  <script src="/dflip/js/libs/jquery.min.js"></script>
  <script src="/dflip/js/dflip.js"></script>
</head>

<body class="bg-red-300 overflow-hidden m-0 p-0 w-full h-[100dvh] bg-[#FDFDFC] text-[#1b1b18]">

  <main class="w-full h-full flex items-center justify-center bg-green-300 ">
    <div class="_df_book w-full h-[100dvh] max-w-full overflow-hidden"
         id="df_manual_book"
         data-option="dflipOptions">
    </div>

    <script>
      window.dflipOptions = {
        source: '/pdf/the-three-musketeers.pdf'
      }
    </script>
  </main>

</body>
</html>
