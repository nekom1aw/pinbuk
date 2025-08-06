<div>
    {{-- In work, do what you enjoy. --}}

    @if ($buku && $buku->file)
    <div class="w-full h-full flex items-center justify-center">
        <div
            class="_df_book w-full h-[calc(100vh-4rem)] overflow-hidden"
            id="df_manual_book"
            data-option="dflipOptions">
        </div>

        {{-- Inject nilai file dari database --}}
        <script>
            window.dflipOptions = {
                source: "{{ $buku->file }}"
            };
        </script>
    </div>
    @else
    <div class="text-center py-10 text-red-600 font-semibold text-lg">
        Buku digital tidak tersedia.
    </div>
    @endif
</div>