<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Post Card -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8">

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $post->title }}
                </h1>

                <!-- Meta -->
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    By <span class="font-medium">{{ $post->user->name }}</span>
                    • {{ $post->published_at?->format('F d, Y') ?? 'Draft' }}
                </p>

                <!-- Stats -->
                <div class="mt-4 flex gap-6 text-sm text-gray-600 dark:text-gray-400">
                    <span>💬 {{ $post->comments->count() }} comments</span>
                    <span>❤️ {{ $post->likes->count() }} likes</span>
                </div>

                <!-- Divider -->
                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <!-- Content -->
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-between items-center">

                    <!-- Back -->
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">
                        ← Back to Posts
                    </a>

                    <!-- Owner Actions -->
                    @can('update', $post)
                        <div class="flex gap-4">
                            <a href="{{ route('dashboard.posts.edit', $post) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('dashboard.posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')

                                <button class="px-4 py-2 bg-red-600 text-white rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>

            </div>

            <!-- Comments Section (Optional placeholder) -->
            <div class="mt-10 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">
                    Comments ({{ $post->comments->count() }})
                </h3>

                @forelse ($post->comments as $comment)
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700 pb-3">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            {{ $comment->content }}
                        </p>
                        <span class="text-xs text-gray-500">
                            — {{ $comment->user->name }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
