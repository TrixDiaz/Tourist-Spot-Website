<div class="mx-auto max-w-7xl rounded-xl">
    <div x-data="{ 
        activeSlide: 0,
        slides: [
            { 
                id: 0, 
                src: '/images/home.png',
                title: 'Your Gateway to',
                subtitle: 'Unforgettable Adventures',
                description: 'Experience the World\'s Wonders, One Journey at a Time.'
            },
            { 
                id: 1, 
                src: '/images/home.png',
                title: 'Your Gateway to',
                subtitle: 'Unforgettable Adventures',
                description: 'Experience the World\'s Wonders, One Journey at a Time.'
            },
            { 
                id: 2, 
                src: '/images/home.png',
                title: 'Your Gateway to',
                subtitle: 'Unforgettable Adventures',
                description: 'Experience the World\'s Wonders, One Journey at a Time.'
            },
            { 
                id: 3, 
                src: '/images/home.png',
                title: 'Your Gateway to',
                subtitle: 'Unforgettable Adventures',
                description: 'Experience the World\'s Wonders, One Journey at a Time.'
            },
            { 
                id: 4, 
                src: '/images/home.png',
                title: 'Your Gateway to',
                subtitle: 'Unforgettable Adventures',
                description: 'Experience the World\'s Wonders, One Journey at a Time.'
            }
        ],
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
                            <span x-text="slide.subtitle" class="block leading-tight"></span>
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

        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
            <template x-for="(slide, index) in slides" :key="index">
                <button type="button"
                    class="w-3 h-3 rounded-full transition-all ease-in-out duration-300"
                    :class="activeSlide === index ? 'bg-white scale-125' : 'bg-white/50 scale-100'"
                    @click="activeSlide = index"
                    :aria-current="activeSlide === index"
                    :aria-label="'Slide ' + (index + 1)">
                </button>
            </template>
        </div>
    </div>
</div>