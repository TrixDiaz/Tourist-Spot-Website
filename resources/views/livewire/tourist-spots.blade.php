<div class="mx-auto max-w-7xl min-h-screen mt-12">
    <div class="flex flex-row items-center justify-between">
        <h1 class="text-[#19147A] text-3xl md:text-4xl font-bold mb-6"><span class="text-slate-900">Choose your </span>Spot</h1>
        <div class="flex flex-row items-center justify-center gap-4">
            <form class="max-w-md mx-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.500ms="search" type="search" id="default-search" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..." required />
                </div>
            </form>
            <button @click="filterOpen = true">
                <x-icons.filter-icon class="w-5 h-5 cursor-pointer" />
            </button>
        </div>
    </div>

    <!-- Content Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($touristSpots as $spot)
        <div class="group mx-2 grid max-w-screen-lg grid-cols-1 space-x-8 overflow-hidden rounded-lg border text-gray-700 shadow transition hover:shadow-lg sm:mx-auto sm:grid-cols-5">
            <a href="#" class="col-span-2 text-left text-gray-600 hover:text-gray-700">
                <div class="group relative h-full w-full overflow-hidden">
                    <img src="https://placehold.co/600x400" alt="" class="h-full w-full border-none object-cover text-gray-700 transition group-hover:scale-125" />
                    <!-- <span class="absolute top-2 left-2 rounded-full bg-yellow-200 px-2 text-xs font-semibold text-yellow-600">Unity</span> -->
                    <img src="/images/AnbWyIjnwNbW9Wz6c_cja.svg" class="absolute inset-1/2 w-10 max-w-full -translate-x-1/2 -translate-y-1/2 transition group-hover:scale-125" alt="" />
                </div>
            </a>
            <div class="col-span-3 flex flex-col space-y-2 pr-8 text-left">
                <a href="#" class="mt-3 overflow-hidden text-xl font-semibold"> {{ $spot->address }} </a>
                <p class="overflow-hidden text-sm">{{ $spot->description }}</p>
                <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-700">{{ $spot->name }}</a>
                <!-- Ratings -->
                <div class="flex flex-row items-center justify-between py-2">
                    <div class="mt-2 flex items-center">
                        <svg class="block h-3 w-3 align-middle text-yellow-500 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" class=""></path>
                        </svg>
                        <svg class="block h-3 w-3 align-middle text-yellow-500 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" class=""></path>
                        </svg>
                        <svg class="block h-3 w-3 align-middle text-yellow-500 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" class=""></path>
                        </svg>
                        <svg class="block h-3 w-3 align-middle text-yellow-500 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" class=""></path>
                        </svg>
                        <svg class="block h-3 w-3 align-middle text-gray-400 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" class=""></path>
                        </svg>
                    </div>
                    <div>
                        <x-icons.arrow-top-right-on-square-icon class="w-4 h-4 hover:text-slate-950 cursor-pointer" />
                    </div>
                </div>
                <!-- End of Ratings -->
            </div>
        </div>
        @endforeach
    </div>

    <!-- Load More Button -->
    <div class="flex justify-center items-center mt-8 mb-8">
        @if($touristSpots->hasMorePages())
        <button
            wire:click="loadMore"
            wire:loading.attr="disabled"
            class="px-6 py-3 text-sm font-semibold text-black disabled:opacity-50 hover:underline">
            <div class="flex flex-row items-center justify-center gap-1">
                <span wire:loading.remove>See more</span>
                <span wire:loading>Loading...</span>
                <x-icons.chevron-down-icon class="w-4 h-4" />
            </div>
        </button>
        @endif
    </div>

    <!-- Filter Drawer -->
    <div x-data="{ filterOpen: false }" @keydown.escape.window="filterOpen = false">
        <!-- Backdrop -->
        <div x-show="filterOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-40"
            @click="filterOpen = false">
        </div>

        <!-- Drawer -->
        <div x-show="filterOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-lg z-50"
            @click.away="filterOpen = false">

            <!-- Drawer Content -->
            <div class="h-full p-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold">Filters</h3>
                    <button @click="filterOpen = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Add your filter content here -->
                <div class="space-y-4">
                    <!-- Filter content goes here -->
                </div>
            </div>
        </div>

    </div>
</div>