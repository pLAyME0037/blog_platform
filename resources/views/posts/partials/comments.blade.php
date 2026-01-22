<div class="p-4 border-t border-gray-100 dark:border-gray-700">
    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">
        Comments ({{ $post->comments->count() }})
    </h3>

    <!-- Comment Form -->
    @auth
        <form action="{{ route('comments.store', $post) }}"
            method="POST"
            class="mb-8">
            @csrf
            <textarea id="comment-box"
                name="content"
                rows="2"
                class="w-full bg-transparent border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-blue-500 focus:ring-0 px-0 text-lg placeholder-gray-500 text-gray-900 dark:text-gray-100 resize-none"
                placeholder="Post your reply..."
                required></textarea>
            <button type="submit"
                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Post Comment
            </button>
        </form>
    @else
        <p class="mb-8 text-gray-600 dark:text-gray-400">
            Please <a href="{{ route('login') }}"
                class="text-blue-500 underline">log in</a> to comment.
        </p>
    @endauth

    <!-- Comment List -->
    <div class="space-y-6">
        @foreach ($post->comments as $comment)
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Delete Button Logic -->
                    @auth
                        @if (Auth::id() === $comment->user_id || Auth::id() === $post->user_id)
                            <form action="{{ route('comments.destroy', $comment) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this comment?');">
                                @csrf @method('DELETE')
                                <button class="text-red-500 text-sm hover:underline">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>
                <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $comment->content }}</p>
            </div>
        @endforeach
    </div>
</div>
