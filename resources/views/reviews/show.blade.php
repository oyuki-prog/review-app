<x-app-layout>

    <div class="flex h-60 mt-24 overflow-hidden overflow-x-auto items-center pr-4">
        @foreach ($review->images as $image)
            <div class="flex-none ml-4 w-2/5">
                <img src="{{ Storage::url('reviews/' . $image->name) }}" class="object-contain">
            </div>
        @endforeach
    </div>
    <div class="container mx-auto my-8">
        @include('partial.flash')
        @include('partial.errors')
        <div class="mb-8">
            <h2 class="text-2xl block mb-4">{{ $review->title }}</h2>
            <p>{!! nl2br(e($review->body)) !!}</p>
        </div>
        <div class="flex justify-end">
            @can('update', $review)
                <a href="{{ route('reviews.edit', $review) }}"
                    class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded inline-block mr-4">編集</a>
            @endcan
            @can('delete', $review)
                <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="if(!confirm('本当に削除しますか？')){return false}"
                        class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded inline-block mr-4">削除</button>
                </form>
            @endcan
            <a href="{{ route('reviews.index') }}"
                class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">戻る</a>
        </div>
    </div>
</x-app-layout>
