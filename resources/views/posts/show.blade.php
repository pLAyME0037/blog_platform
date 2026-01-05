<x-app-layout>
    <!-- Main Layout Wrapper: Center Content + Right Sidebar -->
    <div class="max-w-7xl mx-auto flex justify-center sm:px-6 lg:px-8 py-6 gap-8">

        <!-- 📱 CENTER COLUMN (The Feed/Post) -->
        <main class="w-full lg:w-2/3 max-w-2xl">

            <!-- Back Button (Sticky Header) -->
            <div
                class="sticky top-0 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md mb-4 py-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:rounded-lg">
                <a href="{{ route('posts.index') }}"
                    class="flex items-center text-gray-800 dark:text-gray-200 font-bold text-lg hover:bg-gray-100 dark:hover:bg-gray-800 p-2 rounded-full w-fit transition">
                    <svg class="w-5 h-5 mr-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Post
                </a>
            </div>

            <!-- The Tweet/Post Card -->
            <article
                class="bg-white dark:bg-gray-800 sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">

                <!-- 1. User Header -->
                <div class="flex items-center p-4">
                    <div class="flex-shrink-0 mr-3">
                        <!-- Avatar Placeholder -->
                        <div
                            class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-xl font-bold text-gray-600">
                            {{ substr($post->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-gray-100 text-base">
                            {{ $post->user->name }}
                        </div>
                        <div class="text-gray-500 text-sm">
                            {{ '@' . Str::slug($post->user->name, '') }}
                        </div>
                    </div>
                    <!-- Menu Dots (Optional) -->
                    <div class="ml-auto text-gray-400">
                        <svg class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- 2. Post Content (Big Text) -->
                <div class="px-4 pb-2">
                    <p class="text-gray-900 dark:text-gray-100 text-xl leading-normal whitespace-pre-wrap">
                        {{ $post->content }}
                    </p>
                </div>

                <!-- 3. Image Grid (Twitter Style) -->
                @if ($post->images->count() > 0)
                    <div class="mt-3 px-4 pb-2">
                        <div
                            class="grid gap-1 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700
                            {{ $post->images->count() == 1 ? 'grid-cols-1' : 'grid-cols-2' }}
                        ">
                            @foreach ($post->images as $image)
                                <div class="relative bg-gray-100 dark:bg-gray-900 aspect-[16/9]">
                                    <a href="{{ asset('storage/' . $image->image_path) }}"
                                        target="_blank">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            class="absolute inset-0 w-full h-full object-cover hover:opacity-90 transition">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 4. Date & Metadata -->
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-500 hover:underline text-sm">
                        {{ $post->created_at->format('g:i A · M j, Y') }}
                    </span>
                    <span class="text-gray-500 text-sm"> · </span>
                    <span class="text-gray-500 text-sm font-bold">Views Coming Soon</span>
                </div>

                <!-- 5. Stats Line (Likes/Comments count) -->
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex gap-6">
                    <div class="flex gap-1">
                        <span class="font-bold text-gray-900 dark:text-gray-100">{{ $post->comments->count() }}</span>
                        <span class="text-gray-500">Comments</span>
                    </div>
                    <!-- Likes Count Placeholder (Dev 5) -->
                    <div class="flex gap-1">
                        <span class="font-bold text-gray-900 dark:text-gray-100"
                            id="like-count-display">0</span>
                        <span class="text-gray-500">Likes</span>
                    </div>
                </div>

                <!-- 6. Action Bar (Icons) -->
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 flex justify-around">
                    <!-- Comment Icon -->
                    <button class="p-2 text-gray-500 hover:text-blue-500 hover:bg-blue-50 rounded-full transition group"
                        onclick="document.getElementById('comment-box').focus()">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </button>

                    <!-- Repost (Static) -->
                    <button
                        class="p-2 text-gray-500 hover:text-green-500 hover:bg-green-50 rounded-full transition group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </button>

                    <!-- Like Icon (Dev 5 Placeholder) -->
                    <!-- Like Button Component -->
                    <form action="{{ route('posts.like', $post) }}"
                        method="POST"
                        class="inline">
                        @csrf
                        <button
                            class="group flex items-center gap-1 p-2 rounded-full transition 
        {{ Auth::user() && Auth::user()->likes->contains($post->id) ? 'text-pink-600' : 'text-gray-500 hover:text-pink-500 hover:bg-pink-50' }}">

                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform {{ Auth::user() && Auth::user()->likes->contains($post->id) ? 'fill-current' : 'fill-none' }}"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>

                            <!-- Count -->
                            <span
                                class="text-sm font-bold {{ Auth::user() && Auth::user()->likes->contains($post->id) ? 'text-pink-600' : '' }}">
                                {{ $post->likes->count() }}
                            </span>
                        </button>
                    </form>

                    <!-- Share (Static) -->
                    <button
                        class="p-2 text-gray-500 hover:text-blue-500 hover:bg-blue-50 rounded-full transition group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- 7. Comments Section -->
                <div class="bg-white dark:bg-gray-800">
                    @include('posts.partials.comments')
                </div>
            </article>
        </main>

        <!-- 🖥️ RIGHT SIDEBAR (Desktop Only) -->
        <aside class="hidden lg:block w-1/3 max-w-sm">
            <div class="sticky top-24 space-y-4">

                <!-- Search Box -->
                <div
                    class="bg-gray-100 dark:bg-gray-800 rounded-full flex items-center p-3 border border-transparent focus-within:border-blue-500 focus-within:bg-white focus-within:ring-1 focus-within:ring-blue-500 dark:focus-within:bg-gray-900 transition">
                    <svg class="w-5 h-5 text-gray-500 ml-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text"
                        placeholder="Search posts"
                        class="bg-transparent border-none focus:ring-0 w-full text-gray-700 dark:text-gray-200 ml-2 placeholder-gray-500">
                </div>

                <!-- Author Card -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-xl mb-3 text-gray-900 dark:text-gray-100">About the Author</h3>

                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($post->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-gray-100">{{ $post->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ '@' . Str::slug($post->user->name, '') }}</div>
                        </div>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        Content creator and writer on this platform. Joining the conversation one post at a time.
                    </p>

                    <button
                        class="w-full bg-black dark:bg-white text-white dark:text-black font-bold py-2 rounded-full hover:opacity-80 transition">
                        Follow
                    </button>
                </div>

                <!-- Footer Links -->
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-gray-500 px-2">
                    <a href="#"
                        class="hover:underline">Terms of Service</a>
                    <a href="#"
                        class="hover:underline">Privacy Policy</a>
                    <a href="#"
                        class="hover:underline">Cookie Policy</a>
                    <span>© {{ date('Y') }} Blog Platform</span>
                </div>
            </div>
        </aside>

    </div>
</x-app-layout>
