<x-app-layout>
    <div class="max-w-7xl mx-auto flex justify-center sm:px-6 lg:px-8 py-6 gap-8">

        <!-- 📱 CENTER COLUMN (The Feed) -->
        <main class="w-full lg:w-2/3 max-w-2xl">

            <!-- Mobile/Feed Header -->
            <div
                class="sticky top-0 z-20 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 p-4 mb-4 sm:rounded-xl sm:border">
                <h2 class="font-bold text-xl text-gray-900 dark:text-gray-100">Home</h2>
            </div>

            <!-- Create Post Box (Visible if logged in) -->
            @auth
                <div
                    class="bg-white dark:bg-gray-800 p-4 border-b sm:border border-gray-200 dark:border-gray-700 sm:rounded-xl mb-4">
                    <div class="flex gap-4">
                        <div
                            class="h-10 w-10 rounded-full bg-gray-300 flex-shrink-0 flex items-center justify-center font-bold text-gray-600">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-grow">
                            <a href="{{ route('dashboard.posts.create') }}"
                                class="block w-full text-gray-500 text-lg py-2">What is happening?!</a>
                            <div
                                class="flex justify-between items-center mt-4 border-t border-gray-100 dark:border-gray-700 pt-3">
                                <div class="flex space-x-2 text-blue-500">
                                    <!-- Mock Icons -->
                                    <svg class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <a href="{{ route('dashboard.posts.create') }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1.5 px-4 rounded-full transition text-sm">
                                    Post
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- THE FEED LOOP -->
            <div class="space-y-4 pb-20">
                @foreach ($posts as $post)
                    @php
                        // Check user interactions (Optimized for View)
                        $hasLiked = Auth::check() && Auth::user()->likes->contains($post->id);
                        $hasCommented = Auth::check() && $post->comments->where('user_id', Auth::id())->count() > 0;
                        // Share logic would go here if DB existed
                    @endphp

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
                                <!-- Header -->
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-1 overflow-hidden">
                                        <span class="font-bold text-gray-900 dark:text-gray-100 truncate">
                                            {{ $post->user->name }}
                                        </span>
                                        <span class="text-gray-500 text-sm truncate">
                                            {{ '@' . Str::slug($post->user->name, '') }}
                                        </span>
                                        <span class="text-gray-500 text-sm">·</span>
                                        <span class="text-gray-500 text-sm hover:underline">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <!-- Options Dot -->
                                    <div class="text-gray-400">
                                        <svg class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Text -->
                                <p class="text-gray-900 dark:text-gray-100 mb-2 leading-normal whitespace-pre-line">
                                    {{ Str::limit($post->content, 280) }}
                                </p>

                                <!-- Images Preview (Multi-Select Grid) -->
                                @php
                                    $imgCount = $post->images->count();
                                @endphp

                                @if ($imgCount > 0)
                                    <div
                                        class="mt-3 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 grid gap-0.5 
                                        {{ $imgCount === 1 ? 'grid-cols-1' : 'grid-cols-2' }}">

                                        @foreach ($post->images->take(4) as $image)
                                            <div
                                                class="relative {{ $imgCount === 1 ? 'aspect-[16/9]' : 'aspect-square' }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                    class="absolute inset-0 w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Action Footer (Icons) -->
                                <div class="flex justify-between mt-3 max-w-md"
                                    onclick="event.stopPropagation()">

                                    <!-- Comment Action -->
                                    <div
                                        class="flex items-center gap-2 group transition-colors 
                                        {{ $hasCommented ? 'text-blue-500' : 'text-gray-500 hover:text-blue-500' }}">
                                        <div
                                            class="p-2 rounded-full group-hover:bg-blue-50 dark:group-hover:bg-blue-900/30">
                                            <svg class="w-5 h-5 {{ $hasCommented ? 'fill-current' : 'fill-none' }}"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-sm">{{ $post->comments_count }}</span>
                                    </div>

                                    <!-- Share Action (Static / No DB) -->
                                    <div
                                        class="flex items-center gap-2 group text-gray-500 hover:text-green-500 transition-colors">
                                        <div
                                            class="p-2 rounded-full group-hover:bg-green-50 dark:group-hover:bg-green-900/30">
                                            <svg class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Like Action -->
                                    <form action="{{ route('posts.like', $post) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-2 group transition-colors 
                                            {{ $hasLiked ? 'text-pink-600' : 'text-gray-500 hover:text-pink-500' }}">
                                            <div
                                                class="p-2 rounded-full group-hover:bg-pink-50 dark:group-hover:bg-pink-900/30">
                                                <svg class="w-5 h-5 {{ $hasLiked ? 'fill-current' : 'fill-none' }}"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-sm">{{ $post->likes_count }}</span>
                                        </button>
                                    </form>
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

        <!-- 🖥️ RIGHT SIDEBAR -->
        <aside class="hidden lg:block w-1/3 max-w-sm">
            <div class="sticky top-24 space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-xl mb-4 text-gray-900 dark:text-gray-100">Trends for you</h3>
                    <div class="space-y-4">
                        <div
                            class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 p-2 -mx-2 rounded transition">
                            <div class="text-xs text-gray-500">Trending in Tech</div>
                            <div class="font-bold text-gray-800 dark:text-gray-200">#Laravel</div>
                            <div class="text-xs text-gray-500">12.5K Posts</div>
                        </div>
                        <div
                            class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 p-2 -mx-2 rounded transition">
                            <div class="text-xs text-gray-500">Politics · Trending</div>
                            <div class="font-bold text-gray-800 dark:text-gray-200">#Election2024</div>
                            <div class="text-xs text-gray-500">54K Posts</div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</x-app-layout>
