<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                My Posts
            </h2>
            <a href="{{ route('dashboard.posts.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-full shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"></path>
                </svg>
                Create New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if ($posts->count() == 0)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-12 text-center border border-gray-100 dark:border-gray-700">
                    <div
                        class="bg-gray-50 dark:bg-gray-700 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">No posts yet</h3>
                    <p class="text-gray-500 mb-6">Share your first thought with the world!</p>
                    <a href="{{ route('dashboard.posts.create') }}"
                        class="text-blue-600 hover:text-blue-500 font-bold hover:underline">Write a post &rarr;</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($posts as $post)
                        <div
                            class="group relative bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-200 hover:border-blue-300 dark:hover:border-blue-700 flex flex-col sm:flex-row gap-5">

                            <!-- Thumbnail -->
                            <div class="flex-shrink-0">
                                @if ($post->images->count() > 0)
                                    <img src="{{ asset('storage/' . $post->images->first()->image_path) }}"
                                        class="w-full sm:w-48 h-32 object-cover rounded-lg shadow-inner border border-gray-100 dark:border-gray-700">
                                @else
                                    <div
                                        class="w-full sm:w-48 h-32 bg-gray-100 dark:bg-gray-700 rounded-lg flex flex-col items-center justify-center text-gray-400 border border-gray-200 dark:border-gray-600">
                                        <svg class="w-8 h-8 mb-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-semibold">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h3
                                            class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 transition mb-1 line-clamp-1">
                                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                        </h3>

                                        <!-- 3-DOT DROPDOWN (Alpine.js) -->
                                        <div x-data="{ open: false }"
                                            class="relative ml-2">
                                            <button @click="open = !open"
                                                @click.outside="open = false"
                                                class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition">
                                                <svg class="w-5 h-5"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <div x-show="open"
                                                x-cloak
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-100 dark:border-gray-700 z-50 overflow-hidden">

                                                <a href="{{ route('dashboard.posts.edit', $post) }}"
                                                    class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit Post
                                                </a>

                                                <form action="{{ route('dashboard.posts.destroy', $post) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Delete this post?');">
                                                    @csrf @method('DELETE')
                                                    <button
                                                        class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center">
                                                        <svg class="w-4 h-4 mr-2"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-sm text-gray-500 mb-3 flex items-center">
                                        <span>{{ $post->created_at->format('F j, Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <span class="{{ $post->published_at ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $post->published_at ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>

                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                        {{ $post->content }}
                                    </p>
                                </div>

                                <!-- Stats Footer -->
                                <div
                                    class="flex items-center gap-6 text-sm text-gray-500 border-t border-gray-100 dark:border-gray-700 pt-3">
                                    <div class="flex items-center gap-1.5"
                                        title="Comments">
                                        <svg class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        {{ $post->comments_count ?? 0 }}
                                    </div>
                                    <div class="flex items-center gap-1.5"
                                        title="Likes">
                                        <svg class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        {{ $post->likes_count ?? 0 }}
                                    </div>
                                    <div class="ml-auto flex items-center gap-1.5 text-blue-600 hover:underline">
                                        <a href="{{ route('posts.show', $post) }}">View Post &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
