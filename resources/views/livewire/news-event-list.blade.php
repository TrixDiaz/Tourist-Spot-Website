<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 min-h-screen mt-6">
    <p class="text-[#19147A] text-3xl md:text-4xl font-bold mb-4 sm:mb-6">News & Events</p>

    <div class="space-y-6 sm:space-y-8">
        @forelse($newsEventCategories as $category)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <div class="shadow-lg rounded-lg p-4 space-y-4">
                <div class="aspect-video">
                    @if($category->images)
                    <img src="{{ Storage::url($category->images) }}" alt="News Event" class="w-full h-full object-cover rounded-md">
                    @else
                    <img src="https://placehold.co/600x400" alt="News Event" class="w-full h-full object-cover rounded-md">
                    @endif
                </div>
                <div class="space-y-3">
                    <p class="text-xl sm:text-2xl font-bold">{{ $category->name }}</p>
                    <p class="text-sm sm:text-base">{{ $category->description }}</p>
                    <p class="text-sm text-gray-600">{{ $category->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="shadow-lg rounded-lg p-4">
                <div class="h-[400px] sm:h-[510px] overflow-y-auto space-y-4">
                    @forelse($category->newsEvents as $news)
                    <div class="flex flex-col justify-center mx-auto max-w-md">
                        <p class="text-lg sm:text-2xl font-bold">{{ $news->title }}</p>
                        <p class="text-sm sm:text-md">{{ $news->description }}</p>
                        <p class="text-xs sm:text-sm text-gray-600">{{ $news->created_at->format('M d, Y') }}</p>
                        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    </div>
                    @empty
                    <p class="text-center text-gray-500">No news events found in this category</p>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">No categories found</p>
        @endforelse
    </div>

    @if($newsEventCategories->count() >= $limit)
    <div class="flex justify-center my-8">
        <x-secondary-button
            wire:click="loadMore">
            See More
        </x-secondary-button>
    </div>
    @endif
</div>