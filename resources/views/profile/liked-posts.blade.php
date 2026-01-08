<x-app-layout>
    <div class="max-w-7xl mx-auto flex justify-center sm:px-6 lg:px-8 py-6 gap-8">

        <!-- 📱 CENTER COLUMN -->
        <main class="w-full lg:w-2/3 max-w-2xl">

            <!-- Header -->
            <div
                class="sticky top-0 z-20 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 p-4 mb-4 sm:rounded-xl sm:border flex items-center gap-4">
                <a href="{{ route('posts.index') }}"
                    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition">
                    <svg class="w-5 h-5 text-gray-800 dark:text-gray-200"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-bold text-xl text-gray-900 dark:text-gray-100">
                    Liked Posts
                </h2>
            </div>

            @if ($posts->count() === 0)
                <div class="text-center py-10 text-gray-500">
                    <p class="text-lg">You haven't liked any posts yet.</p>
                    <a href="{{ route('posts.index') }}"
                        class="text-blue-500 hover:underline">Go explore!</a>
                </div>
            @endif

            <!-- THE FEED LOOP -->
            <div class="space-y-4 pb-20">
                @foreach ($posts as $post)
                    <article
                        class="bg-white dark:bg-gray-800 border-b sm:border border-gray-200 dark:border-gray-700 sm:rounded-xl overflow-hidden hover:bg-gray-50 dark:hover:bg-gray-800/50 transition cursor-pointer"
                        onclick="window.location='{{ route('posts.show', $post) }}'">
                        <div class="p-4 flex gap-4">

                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div
                                    class="h-10 w-10 rounded-full bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-grow min-w-0">
                                <!-- User Info -->
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-1 overflow-hidden">
                                        <span
                                            class="font-bold text-gray-900 dark:text-gray-100 truncate">{{ $post->user->name }}</span>
                                        <span
                                            class="text-gray-500 text-sm truncate">{{ '@' . Str::slug($post->user->name, '') }}</span>
                                        <span class="text-gray-500 text-sm">·</span>
                                        <span
                                            class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Text -->
                                <p class="text-gray-900 dark:text-gray-100 mb-2 leading-normal">
                                    {{ Str::limit($post->content, 280) }}
                                </p>

                                <!-- Image Preview -->
                                @if ($post->images->count() > 0)
                                    <div
                                        class="mt-3 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 aspect-[16/9]">
                                        <img src="{{ asset('storage/' . $post->images->first()->image_path) }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endif

                                <!-- Like Indicator -->
                                <div class="mt-3 text-sm text-pink-500 flex items-center gap-1">
                                    <svg class="w-4 h-4 fill-current"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    You liked this
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </main>

    </div>
</x-app-layout>
