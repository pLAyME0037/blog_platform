<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Posts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse ($posts as $post)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                    <!-- Title -->
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $post->title }}
                    </h3>

                    <!-- Meta -->
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        By <span class="font-medium">{{ $post->user->name }}</span>
                        • {{ $post->published_at?->format('M d, Y') ?? 'Draft' }}
                    </p>

                    <!-- Content Preview -->
                    <p class="mt-4 text-gray-700 dark:text-gray-300">
                        {{ Str::limit($post->content, 150) }}
                    </p>

                    <!-- Stats -->
                    <div class="mt-4 flex items-center gap-6 text-sm text-gray-600 dark:text-gray-400">
                        <span>💬 {{ $post->comments->count() }} comments</span>
                        <span>❤️ {{ $post->likes->count() }} likes</span>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex justify-between items-center">

                        <!-- Read More -->
                        <a href="{{ route('dashboard.posts.view', $post) }}"
                           class="text-indigo-600 hover:underline">
                            Read more →
                        </a>

                        <!-- Owner Actions -->
                        @can('update', $post)
                            <div class="flex gap-4">
                                <a href="{{ route('dashboard.posts.edit', $post) }}"
                                   class="text-blue-500 hover:underline">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('dashboard.posts.destroy', $post) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-500 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 dark:text-gray-400">
                    No posts found.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
