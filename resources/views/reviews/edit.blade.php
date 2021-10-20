<x-app-layout>

    <div class="flex h-60 mt-24 overflow-hidden overflow-x-auto items-center mb-4">
        @foreach ($review->images as $image)
            <div class="flex-none mr-4 w-2/5">
                <img src="{{ Storage::url('reviews/' . $image->name) }}" class="object-contain">
            </div>
        @endforeach
    </div>
    <div class="container mx-auto my-8">
        <div class="w-full">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                action="{{ route('reviews.update', $review) }}" method="POST">
                @csrf
                @method('PATCH')
                @include('partial.flash')
                @include('partial.errors')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        タイトル
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="title" type="text" name="title" value="{{ old('title', $review->title) }}">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="body">
                        本文
                    </label>
                    <textarea name="body" id="body"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-40">{{ old('body', $review->body) }}</textarea>
                </div>
                <div class="flex items-center justify-end">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        更新
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
