@if (session('flash_message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        {{ session('flash_message') }}
    </div>
@endif
