<div class="mx-auto max-w-7xl min-h-screen mt-4" x-data="{ filterOpen: false, showModal: false, selectedSpot: null }">
    <div class="flex flex-row items-center justify-between">
        <h1 class="text-[#19147A] text-3xl md:text-4xl font-bold mb-6"><span class="text-slate-900">Choose your </span>Dining</h1>
        <div class="flex flex-row items-center justify-center gap-4">
            <form class="max-w-md mx-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.500ms="search" type="search" id="default-search" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by name or address" required />
                </div>
            </form>
            <button @click="filterOpen = true">
                <x-icons.filter-icon class="w-5 h-5 cursor-pointer" />
            </button>
        </div>
    </div>

    <!-- Content Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($restaurants as $restaurant)
        <div class="group mx-2 grid max-w-screen-lg grid-cols-1 space-x-8 overflow-hidden rounded-lg border text-gray-700 shadow transition hover:shadow-lg sm:mx-auto sm:grid-cols-5"
            x-data="{ shown: false }"
            x-intersect="shown = true"
            x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-16"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            :class="{ 'opacity-0': !shown, 'opacity-100': shown }"
            style="transition-delay: calc({{ $loop->index }} * 100ms);">
            <a href="#" class="col-span-2 text-left text-gray-600 hover:text-gray-700">
                <div class="group relative h-full w-full overflow-hidden">
                    @if($restaurant->images && is_array($restaurant->images) && count($restaurant->images) > 0)
                        <img src="{{ Storage::disk('public')->url($restaurant->images[0]) }}"
                             alt="{{ $restaurant->name }}"
                             class="h-full w-full border-none object-cover text-gray-700 transition group-hover:scale-125" />
                    @else
                        <img src="https://placehold.co/600x400" alt="placeholder"
                             class="h-full w-full border-none object-cover text-gray-700 transition group-hover:scale-125" />
                    @endif
                    <span class="absolute uppercase top-2 left-2 rounded-full bg-yellow-200 px-2 text-xs font-semibold text-yellow-600">
                        {{ $hotel->type ?? '' }}
                    </span>
                </div>
            </a>
            <div class="col-span-3 flex flex-col space-y-2 pr-8 text-left">
                <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-700">{{ $restaurant->name }}</a>
                <a href="#" class="mt-3 overflow-hidden text-xl font-semibold"> {{ $restaurant->address }} </a>
                <p class="overflow-hidden text-sm">{{ $restaurant->description }}</p>
                <!-- Ratings -->
                <div class="flex flex-row items-center justify-between py-2">
                    <div class="mt-2 flex items-center">
                        @php
                        $avgRating = round($restaurant->restaurant_feedbacks_avg_rating ?? 0);
                        $formattedRating = number_format($restaurant->restaurant_feedbacks_avg_rating ?? 0, 1);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="block h-3 w-3 align-middle {{ $i <= $avgRating ? 'text-yellow-500' : 'text-gray-400' }} sm:h-4 sm:w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">({{ $formattedRating }})</span>
                    </div>
                    <div>
                        <button @click="showModal = true; selectedSpot = {{ $restaurant->id }}" class="focus:outline-none">
                            <x-icons.arrow-top-right-on-square-icon class="w-4 h-4 hover:text-slate-950 cursor-pointer" />
                        </button>
                    </div>
                </div>
                <!-- End of Ratings -->
            </div>
        </div>
        @endforeach
    </div>

    <!-- Load More Button -->
    <div class="flex justify-center items-center my-8">
        @if($restaurants->count('is_active', true) >= 6 && $restaurants->hasMorePages())
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
    <div @keydown.escape.window="filterOpen = false">
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
                    <h3 class="text-xl text-gray-600 font-semibold">Filters</h3>
                    <button @click="filterOpen = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Filter Star Content -->
                <div class="space-y-4 flex flex-col">
                    <p class="text-gray-600 font-semibold">Rating</p>
                    <ul class="grid grid-cols-2 gap-4">
                        @foreach([5,4,3,2,1] as $stars)
                        <li>
                            <input type="radio"
                                id="{{ $stars }}-stars"
                                wire:model="rating"
                                value="{{ $stars }}"
                                name="rating"
                                class="hidden peer">
                            <label for="{{ $stars }}-stars"
                                class="inline-flex items-center justify-center bg-[#D9D9D9] w-full p-2.5 rounded-md cursor-pointer peer-checked:bg-violet-600 peer-checked:text-white">
                                <p class="text-normal text-center">{{ $stars }} Star{{ $stars > 1 ? 's' : '' }} & up</p>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Clear and Apply Filters -->
                <div class="flex flex-row items-center justify-between gap-4 my-4">
                    <button wire:click="clearFilters"
                        class="bg-transparent hover:bg-[#19147A] hover:text-white text-black w-full px-4 py-2 rounded-md">
                        Clear
                    </button>
                    <button wire:click="applyFilters"
                        @click="filterOpen = false"
                        class="bg-[#19147A] hover:bg-emerald-600 text-white w-full px-4 py-2 rounded-md">
                        Apply
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div x-show="showModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModal = false"></div>

        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                x-data="{ showGallery: null }">
                <!-- Modal Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                        x-show="showGallery === null"
                        x-transition:enter="transition ease duration-250"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease duration-250"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <!-- Map Section - Will appear first on mobile -->
                        <div class="flex flex-col items-end justify-between md:order-2">
                            <button @click="showModal = false" class="text-gray-600 hover:text-gray-900">
                                <x-icons.x-mark-icon class="w-6 h-6" />
                            </button>
                            <div class="mapswrapper w-full h-[300px] md:h-full object-cover rounded-lg mt-4">
                                @foreach($restaurants as $restaurant)
                                <template x-if="selectedSpot === {{ $restaurant->id }}">
                                    <div class="w-full h-full">
                                        <iframe
                                            width="100%"
                                            height="100%"
                                            style="border:0"
                                            loading="lazy"
                                            allowfullscreen
                                            referrerpolicy="no-referrer-when-downgrade"
                                            src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAPS_API_KEY') }}&q={{ $restaurant->address }}">
                                        </iframe>
                                    </div>
                                </template>
                                @endforeach
                                <span class="sr-only">Map location</span>
                            </div>
                        </div>

                        <!-- Content Section - Will appear second on mobile -->
                        <div class="space-y-4 md:order-1">
                            @foreach($restaurants as $restaurant)
                            <template wire:key="restaurant-{{ $restaurant->id }}" x-if="selectedSpot === {{ $restaurant->id }}">
                                <div x-ref="restaurant-{{ $restaurant->id }}">
                                    <p class="text-[#19147A] text-3xl font-semibold">{{ $restaurant->name }}</p>
                                    <p class="font-semibold text-sm text-gray-600 my-4">Address: <br> <span class="font-normal text-md text-black">{{ $restaurant->address }}</span></p>
                                    <p class="font-semibold text-sm text-gray-600">Menu: <br> <span class="font-normal text-md text-black">{{ $restaurant->description }}</span></p>
                                    <button @click="showGallery = selectedSpot"
                                        class="text-[#19147A] underline text-sm rounded-md">
                                        View Photos
                                    </button>
                                </div>
                            </template>
                            @endforeach
                            <!-- Reviews Section -->
                            <div>
                                <p class="text-gray-500 text-md font-semibold mb-4">Feedback and Reviews</p>
                                <div class="space-y-4">
                                    @foreach($restaurants as $restaurant)
                                    <template x-if="selectedSpot === {{ $restaurant->id }}">
                                        <div class="space-y-2 border p-4 rounded-md">
                                            @forelse($restaurant->restaurantFeedbacks()->latest()->take(3)->get() as $review)
                                            <div class="flex items-start gap-4">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start">
                                                        <p class="text-sm font-semibold">{{ $review->user->name }}</p>
                                                        <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-800">{{ $review->comment }}</p>
                                                    <div class="flex items-center mt-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"
                                                            fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                            @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <p class="text-gray-500 text-sm">No reviews yet.</p>
                                            @endforelse

                                            <!-- Add Review Input -->
                                            @auth
                                            <div class="mt-6">
                                                <form wire:submit.prevent="addReview({{ $restaurant->id }})">
                                                    <div class="mb-3">
                                                        <div class="flex items-center space-x-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <button type="button" wire:click="setRating({{ $i }})"
                                                                class="focus:outline-none">
                                                                <svg class="w-5 h-5 {{ $i <= $newReviewRating ? 'text-yellow-500' : 'text-gray-300' }}"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                </svg>
                                                                </button>
                                                                @endfor
                                                        </div>
                                                    </div>
                                                    <div class="relative">
                                                        <input type="text"
                                                            wire:model="newReviewComment"
                                                            class="w-full px-4 py-2 pr-12 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                            placeholder="Enter your feedback...">
                                                        <button type="submit"
                                                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            @else
                                            <div class="mt-6">
                                                <p class="text-sm text-gray-600">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to add a review.</p>
                                            </div>
                                            @endauth
                                        </div>
                                    </template>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Section -->
                    <div x-show="showGallery !== null"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <!-- Back button -->
                        <button @click="showGallery = null"
                            class="mb-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to details
                        </button>

                        <p class="text-gray-500 text-md font-semibold mb-4">Menu Gallery</p>
                        @foreach($restaurants as $restaurant)
                        <div x-show="showGallery === {{ $restaurant->id }}"
                            wire:key="gallery-{{ $restaurant->id }}">
                            <!-- Product Images -->
                            @if($restaurant->products->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($restaurant->products as $product)
                                <div class="aspect-square overflow-hidden rounded-lg relative border border-slate-950">
                                    @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                        onerror="this.src='https://placehold.co/600x400'">
                                    @else
                                    <img src="https://placehold.co/600x400"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @endif
                                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-white">
                                        <p class="font-semibold text-sm">{{ $product->name }}</p>
                                        <p class="text-xs">{{ $product->description }}</p>
                                        <p class="text-xs">₱{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center text-gray-500">No menu items available</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
