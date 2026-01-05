<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Posts</h2>
            <!-- CREATE BUTTON -->
            <a href="{{ route('dashboard.posts.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($posts->count() == 0)
                    <p class="text-gray-500 text-center py-4">You haven't written any posts yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($posts as $post)
                            <div
                                class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $post->title }}
                                    </h3>
                                    <span class="text-sm text-gray-500">Published:
                                        {{ $post->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex space-x-3">
                                    <!-- EDIT BUTTON -->
                                    <a href="{{ route('dashboard.posts.edit', $post) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                                        Edit
                                    </a>

                                    <!-- DELETE BUTTON -->
                                    <form action="{{ route('dashboard.posts.destroy', $post) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
