<div class="mx-auto max-w-7xl min-h-screen mt-4" x-data="{ filterOpen: false, showModal: false, selectedHotel: null, showGallery: false, showEvents: false, showReviews: false  }">
    <div class="flex flex-row items-center justify-between">
        <h1 class="text-[#19147A] text-3xl md:text-4xl font-bold mb-6">
            <span class="text-slate-900">Find your perfect </span>Stay
        </h1>
        <div class="flex flex-row items-center justify-center gap-4">
            <form class="max-w-md mx-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <x-icons.magnifying-glass-icon class="w-4 h-4" />
                    </div>
                    <input wire:model.live.debounce.500ms="search" type="search" id="default-search"
                        class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search by location..." required />
                </div>
            </form>
            <button @click="filterOpen = true">
                <x-icons.filter-icon class="w-5 h-5 cursor-pointer" />
            </button>
        </div>
    </div>

    <!-- Content Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($hotelResorts as $hotel)
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
                    @if($hotel->images && is_array($hotel->images) && count($hotel->images) > 0)
                    <img src="{{ Storage::disk('public')->url($hotel->images[0]) }}"
                        alt="{{ $hotel->name }}"
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
                <a href="#" class="mt-3 overflow-hidden text-xl font-semibold"> {{ $hotel->name }} </a>
                <p class="text-sm text-gray-600">{{ $hotel->address }}</p>
                <p class="overflow-hidden text-sm">{{ $hotel->description }}</p>
                <p class="text-lg font-bold text-[#19147A]">₱{{ number_format($hotel->price, 2) }}/night</p>

                <!-- Ratings -->
                <div class="flex flex-row items-center justify-between py-2">
                    <div class="mt-2 flex items-center">
                        @php
                        $avgRating = round($hotel->reviews_avg_rating ?? 0);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="block h-3 w-3 align-middle {{ $i <= $avgRating ? 'text-yellow-500' : 'text-gray-400' }} sm:h-4 sm:w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">({{ number_format($hotel->reviews_avg_rating, 1) }})</span>
                    </div>
                    <div>
                        <button @click="showModal = true; selectedHotel = {{ $hotel->id }}" class="focus:outline-none">
                            <x-icons.arrow-top-right-on-square-icon class="w-4 h-4 hover:text-slate-950 cursor-pointer" />
                        </button>
                    </div>
                </div>

                <!-- Amenities Tags -->
                @if($hotel->amenities && is_array($hotel->amenities))
                <div class="flex flex-wrap gap-2">
                    @foreach($hotel->amenities as $amenity)
                    <span class="px-2 py-1 text-xs bg-gray-100 rounded-full text-gray-600">{{ $amenity }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add See More Button -->
    <div class="flex justify-center mt-8 mb-6">
        @if($hotelResorts->hasMorePages())
        <button wire:click="loadMore"
            class="px-6 py-2 bg-[#19147A] text-white rounded-md hover:bg-emerald-600 transition-colors duration-200">
            See More
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
        <div x-show="filterOpen" class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-lg z-50">
            <div class="h-full p-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl text-gray-600 font-semibold">Filters</h3>
                    <button @click="filterOpen = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <x-icons.x-mark-icon class="w-6 h-6" />
                    </button>
                </div>

                <!-- Property Type Filter -->
                <div class="space-y-4 flex flex-col mb-6">
                    <p class="text-gray-600 font-semibold">Property Type</p>
                    <ul class="grid grid-cols-2 gap-4">
                        @foreach(\App\Models\HotelResort::TYPE_OPTIONS as $value => $label)
                        <li>
                            <input type="radio"
                                id="type-{{ $value }}"
                                wire:model="type"
                                value="{{ $value }}"
                                class="hidden peer">
                            <label for="type-{{ $value }}"
                                class="inline-flex items-center justify-center bg-[#D9D9D9] w-full p-2.5 rounded-md cursor-pointer peer-checked:bg-violet-600 peer-checked:text-white">
                                <p class="text-normal text-center">{{ $label }}</p>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Rating Filter -->
                <div class="space-y-4 flex flex-col">
                    <p class="text-gray-600 font-semibold">Rating</p>
                    <ul class="grid grid-cols-2 gap-4">
                        @foreach([5,4,3,2,1] as $stars)
                        <li>
                            <input type="radio"
                                id="{{ $stars }}-stars"
                                wire:model="rating"
                                value="{{ $stars }}"
                                class="hidden peer">
                            <label for="{{ $stars }}-stars"
                                class="inline-flex items-center justify-center bg-[#D9D9D9] w-full p-2.5 rounded-md cursor-pointer peer-checked:bg-violet-600 peer-checked:text-white">
                                <p class="text-normal text-center">{{ $stars }} Star{{ $stars > 1 ? 's' : '' }} & up</p>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Range Filter -->
                <div class="space-y-4 flex flex-col mt-4">
                    <p class="text-gray-600 font-semibold">Price Range (per night)</p>
                    <ul class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach([
                        'budget' => '0-100',
                        'mid' => '101-300',
                        'luxury' => '301-1000'
                        ] as $id => $range)
                        <li>
                            <input type="radio"
                                id="{{ $id }}"
                                wire:model="priceRange"
                                value="{{ $range }}"
                                class="hidden peer">
                            <label for="{{ $id }}"
                                class="inline-flex items-center justify-center bg-[#D9D9D9] w-full p-2.5 rounded-md cursor-pointer peer-checked:bg-violet-600 peer-checked:text-white">
                                <p class="text-normal text-center">${{ $range }}</p>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Filter Actions -->
                <div class="flex flex-row items-center justify-between gap-4 mt-8">
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
                x-data="{ showGallery: false, showEvents: false, showReviews: false }">
                <!-- Modal Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                        x-show="!showGallery && !showEvents && !showReviews"
                        x-transition:enter="transition ease duration-250"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease duration-250"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-4">
                        <!-- Map Section - Will appear first on mobile -->
                        <div class="flex flex-col items-end justify-between md:order-2">
                            <button @click="showModal = false" class="text-gray-600 hover:text-gray-900">
                                <x-icons.x-mark-icon class="w-6 h-6" />
                            </button>
                            <div class="mapswrapper w-full h-[300px] md:h-full object-cover rounded-lg mt-4">
                                <iframe loading="lazy" width="100%" height="100%" allowfullscreen
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=Quezon%20City&zoom=10&maptype=roadmap">
                                </iframe>
                                <span class="sr-only">Map</span>
                            </div>
                        </div>

                        <!-- Content Section - Will appear second on mobile -->
                        <div class="space-y-4 md:order-1">
                            @foreach($hotelResorts as $hotel)
                            <template x-if="selectedHotel === {{ $hotel->id }}">
                                <div class="space-y-4">
                                    <p class="text-[#19147A] text-3xl font-semibold">{{ $hotel->name }}</p>
                                    <p class="font-semibold text-sm text-gray-600 my-4">Address: <br> <span class="font-normal text-md text-black">{{ $hotel->address }}</span></p>
                                    <p class="font-semibold text-sm text-gray-600">Description: <br> <span class="font-normal text-md text-black">{{ $hotel->description }}</span></p>
                                    <p class="font-semibold text-sm text-gray-600">Accommodation: <br> <span class="font-normal text-md text-black">{{ $hotel->accommodation }}</span></p>
                                    <p class="font-semibold text-sm text-gray-600">
                                        @if($hotel->restaurant)
                                        Restaurant: <br>
                                        <span class="font-normal text-md text-black">
                                            {{ $hotel->restaurant->name }}
                                        </span>
                                        @else
                                        <span class="font-normal text-md text-black">No restaurant available</span>
                                        @endif
                                    </p>
                                    <p class="font-semibold text-sm text-gray-600">Amenities: <br> <span class="font-normal text-md text-black">{{ $hotel->amenities }}</span></p>
                                    <p class="font-semibold text-sm text-gray-600">Price: <br> <span class="font-normal text-md text-black">₱{{ number_format($hotel->price, 2) }}/night</span></p>


                                    <button @click="showEvents = true"
                                        class="text-[#19147A] underline text-sm rounded-md">
                                        View Events
                                    </button>
                                    <div class="flex flex-row items-center justify-between gap-4">
                                        <button @click="showGallery = true"
                                            class="text-[#19147A] underline text-sm rounded-md">
                                            View Photos
                                        </button>
                                        <button @click="showReviews = true"
                                            class="text-[#19147A] underline text-sm rounded-md">
                                            View Reviews
                                        </button>
                                    </div>
                                </div>
                            </template>
                            @endforeach
                        </div>
                    </div>

                    <!-- Gallery Section -->
                    <div x-show="showGallery"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform translate-y-4">
                        <!-- Add back button -->
                        <button @click="showGallery = false"
                            class="mb-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to details
                        </button>

                        <p class="text-gray-500 text-md font-semibold mb-4">Photo Gallery</p>
                        @foreach($hotelResorts as $hotel)
                        <template x-if="selectedHotel === {{ $hotel->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($hotel->images && is_array($hotel->images))
                                <!-- Large featured image on the left -->
                                @if(isset($hotel->images[0]))
                                <div class="aspect-square md:aspect-auto md:h-full overflow-hidden rounded-lg">
                                    <img
                                        src="{{ Storage::disk('public')->url($hotel->images[0]) }}"
                                        alt="{{ $hotel->name }} featured image"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                        onerror="this.src='https://placehold.co/600x400'">
                                </div>
                                @endif

                                <!-- Grid of smaller images on the right -->
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach(array_slice($hotel->images, 1) as $image)
                                    <div class="aspect-square overflow-hidden rounded-lg">
                                        <img
                                            src="{{ Storage::disk('public')->url($image) }}"
                                            alt="{{ $hotel->name }} image"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                            onerror="this.src='https://placehold.co/600x400'">
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="col-span-full text-center text-gray-500">No images available</div>
                                @endif
                            </div>
                        </template>
                        @endforeach
                    </div>

                    <!-- Events Section -->
                    <div x-show="showEvents"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform translate-y-4">
                        <button @click="showEvents = false"
                            class="mb-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to details
                        </button>

                        <p class="text-gray-500 text-md font-semibold mb-4">Events</p>
                        @foreach($hotelResorts as $hotel)
                        <template x-if="selectedHotel === {{ $hotel->id }}">
                            <div class="space-y-4">
                                @if($hotel->newsEventCategories && count($hotel->newsEventCategories) > 0)
                                @foreach($hotel->newsEventCategories as $event)
                                <div class="p-4 border rounded-lg">
                                    <h3 class="font-semibold">{{ $event->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $event->description }}</p>
                                    <p class="text-sm text-gray-600">Date: {{ $event->date }}</p>
                                </div>
                                @endforeach
                                @else
                                <p class="text-gray-500">No events scheduled</p>
                                @endif
                            </div>
                        </template>
                        @endforeach
                    </div>

                    <!-- Reviews Section -->
                    <div x-show="showReviews"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform translate-y-4">
                        <button @click="showReviews = false"
                            class="mb-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to details
                        </button>

                        <p class="text-gray-500 text-md font-semibold mb-4">Reviews</p>
                        @foreach($hotelResorts as $hotel)
                        <template x-if="selectedHotel === {{ $hotel->id }}">
                            <div class="space-y-4">
                                @if($hotel->reviews && count($hotel->reviews) > 0)
                                @foreach($hotel->reviews as $review)
                                <div class="p-4 border rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                    <p class="text-xs text-gray-500 mt-2">By {{ $review->user->name }} on {{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                                @endforeach
                                @else
                                <p class="text-gray-500">No reviews yet</p>
                                @endif
                            </div>
                        </template>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>