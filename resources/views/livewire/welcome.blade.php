<div class="mx-auto max-w-7xl rounded-xl">
    <div x-data="{ 
        activeSlide: 0,
        slides: {{ json_encode($popularSpots->map(function($spot, $index) {
            $images = is_array($spot->images) ? $spot->images : [];
            return [
                'id' => $index,
                'src' => !empty($images) 
                    ? Storage::disk('public')->url($images[0]) 
                    : asset('images/home.png'),
                'title' => $spot->name,
                'description' => $spot->description
            ];
        })) }},
        prev() {
            this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1
        },
        next() {
            this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1
        },
        autoplayInterval: null,
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.next()
            }, 5000)
        },
        stopAutoplay() {
            if (this.autoplayInterval) clearInterval(this.autoplayInterval)
        }
    }"
        x-init="startAutoplay()"
        @mouseenter="stopAutoplay()"
        @mouseleave="startAutoplay()"
        class="relative w-full">
        <!-- Carousel wrapper -->
        <div class="relative overflow-hidden rounded-lg h-[600px] m-4 shadow-lg shadow-gray-900">

            <template x-for="slide in slides" :key="slide.id">
                <div x-show="activeSlide === slide.id"
                    x-transition:enter="transform transition ease-in-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-700"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full"
                    class="absolute inset-0">
                    <img :src="slide.src"
                        class="w-full h-full object-cover object-center"
                        alt="Carousel image">
                    <!-- Content overlay -->
                    <div class="absolute inset-0 flex flex-col justify-center px-8">
                        <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-bold max-w-4xl font-poppins">
                            <span x-text="slide.title" class="block leading-tight"></span>
                        </h1>
                        <p class="text-white text-xl mt-4" x-text="slide.description"></p>

                        <!-- Buttons -->
                        <div class="flex items-center justify-center gap-4 mt-48">
                            <a href="{{ route('tourist-spots') }}"
                                class="px-8 py-2 bg-transparent border border-white text-white rounded-full hover:bg-white/10 transition-all">
                                View Tourist Spots
                            </a>
                            <a href="{{ route('hotel-resorts') }}"
                                class="px-8 py-2 bg-yellow-400 text-black rounded-full hover:bg-yellow-500 transition-all">
                                View Hotel & Restaurants
                            </a>
                            <a href="{{ route('hotel-resorts') }}"
                                class="px-8 py-2 bg-transparent border border-white text-white rounded-full hover:bg-white/10 transition-all">
                                View Resorts
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Combined navigation and indicators container -->
        <div class="absolute bottom-4 left-0     right-0 flex justify-center items-center space-x-6 z-30">
            <!-- Prev button -->
            <!-- <button @click="prev()"
                class="p-2 rounded-full"
                :class="activeSlide === 0 ? 'bg-gray-500 hover:bg-gray-600' : 'bg-gray-500 hover:bg-gray-600'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button> -->

            <!-- Slide indicators -->
            <div class="flex space-x-4">
                <template x-for="(slide, index) in slides" :key="index">
                    <button type="button"
                        class="w-2.5 h-2.5 rounded-full transition-all ease-in-out duration-300"
                        :class="activeSlide === index ? 'bg-orange-500 scale-150' : 'bg-gray-400 scale-100'"
                        @click="activeSlide = index"
                        :aria-current="activeSlide === index"
                        :aria-label="'Slide ' + (index + 1)">
                    </button>
                </template>
            </div>

            <!-- Next button -->
            <!-- <button @click="next()"
                class="p-2 rounded-full"
                :class="activeSlide === slides.length - 1 ? 'bg-gray-500 hover:bg-gray-600' : 'bg-gray-500 hover:bg-gray-600'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button> -->
        </div>
    </div>
</div>