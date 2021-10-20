<x-app-layout>

    <div class="container mx-auto my-24">
        @include('partial.flash')
        @include('partial.errors')

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ml-4 sm:ml-0 gap-4 mb-8">
            @foreach ($reviews as $review)
                <a href="{{ route('reviews.show', $review) }}">
                    <div class="w-full shadow h-56">
                        <img src="{{ $review->first_image_url }}" class="w-full h-2/3 object-cover">
                        <div class="p-2">
                            <p>{{ $review->title }}</p>
                            <p class="text-sm text-gray-500">{{ $review->created_at }}</p>
                        </div>
                    </div>
            @endforeach
            </a>
        </div>
        {{ $reviews->links() }}
    </div>

</x-app-layout>
