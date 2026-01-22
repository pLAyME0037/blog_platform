<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">
                <form action="{{ route('dashboard.posts.update', $post) }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Critical for Updates -->

                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text"
                            name="title"
                            value="{{ old('title', $post->title) }}"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded shadow-sm"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300">
                            Content
                        </label>
                        <textarea name="content"
                            rows="10"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded shadow-sm"
                            required>{{ old('content', $post->content) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300">
                            Add More Images
                        </label>
                        <input type="file"
                            name="images[]"
                            multiple
                            class="w-full border p-2 dark:text-gray-300">
                    </div>

                    <!-- Existing Images Preview (Optional) -->
                    @if ($post->images->count() > 0)
                        <div class="mb-4 flex gap-2">
                            @foreach ($post->images as $img)
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                    class="h-20 w-20 object-cover rounded border">
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-4">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
                            Update Post
                        </button>
                        <a href="{{ route('dashboard.posts.index') }}"
                            class="text-gray-600 dark:text-gray-400 px-4 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
