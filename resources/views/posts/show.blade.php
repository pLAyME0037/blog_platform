<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Post Header -->
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <div>
                            <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
                            <p class="text-gray-500 mt-1">
                                By <span class="font-semibold">{{ $post->user->name }}</span>
                                on {{ $post->created_at->format('F j, Y') }}
                            </p>
                        </div>

                        <!--
                           DEV 5 INTEGRATION ZONE
                           (Dev 5 will build components/like-button.blade.php)
                        -->
                        @if (auth()->check())
                            @includeIf('components.like-button', ['post' => $post])
                        @endif
                    </div>

                    <!-- Post Body -->
                    <div class="prose max-w-none mb-8">
                        {!! nl2br(e($post->body)) !!}
                    </div>

                    <hr class="my-8">

                    <!--
                       DEV 4 INTEGRATION ZONE
                       (Dev 4 will build comments/_index.blade.php)
                    -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold mb-4">Discussion</h3>

                        <!--
                           NOTE: This might throw an error until Dev 4 creates their file.
                           You can comment this out until Dev 4 is ready,
                           or use @includeIf to prevent crashes.
                        -->
                        @includeIf('comments._index', ['comments' => $post->comments, 'post' => $post])
                    </div>

                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('home') }}"
                    class="text-gray-600 hover:text-gray-900">
                    &larr; Back to all posts
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
