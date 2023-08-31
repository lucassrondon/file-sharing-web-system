@if (session()->has('successMessage'))
    <div class="break-all text-sm text-green-600 mt-1 px-4 py-2 text-center border border-transparent rounded-md font-semibold uppercase tracking-widest">
        {{ session('successMessage') }}
    </div>
@endif
@if (session()->has('failMessage'))
    <div class="break-all text-sm text-red-600 mt-1 px-4 py-2 text-center border border-transparent rounded-md font-semibold uppercase tracking-widest">
        {{ session('failMessage') }}
    </div>
@endif