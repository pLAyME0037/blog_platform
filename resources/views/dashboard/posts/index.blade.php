<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            My Posts
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('dashboard.posts.create') }}"
               class="mb-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded">
                + New Post
            </a>

            @foreach ($posts as $post)
                <div class="bg-white dark:bg-gray-800 p-4 mb-3 rounded shadow">
                    <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
                    <p class="text-lg font-semibold">{{ $post->content }}</p>

                    <div class="mt-2 flex gap-4">
                        <a href="{{ route('dashboard.posts.edit', $post) }}"
                           class="text-blue-500">Edit</a>

                        <form method="POST"
                              action="{{ route('dashboard.posts.destroy', $post) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
