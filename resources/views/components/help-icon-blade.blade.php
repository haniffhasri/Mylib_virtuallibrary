{{-- <div class="relative group inline-block">
    <!-- Question Mark SVG Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5 text-blue-600 cursor-pointer"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M8.25 9a3.75 3.75 0 017.5 0c0 2.25-3.75 2.25-3.75 4.5M12 17h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>
    </svg>

    <!-- Tooltip -->
    <div class="absolute bottom-full mb-1 w-48 bg-gray-800 text-white text-sm rounded-md shadow-lg px-2 py-1
                opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
        {{ $slot }}
    </div>
</div> --}}
<div class="relative group inline-block">
    <!-- Question Mark SVG -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <title>Help</title>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8.227 9a3.5 3.5 0 116.546 1.25c-.46.7-1.022 1.023-1.523 1.343-.553.353-.75.74-.75 1.407v.5m.005 3h.01"/>
    </svg>

    <!-- Tooltip -->
    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded-lg px-2 py-1 shadow-md z-10 w-48 text-center">
        {{ $slot }}
    </div>
</div>
