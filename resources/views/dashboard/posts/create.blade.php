<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Create Post
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('dashboard.posts.store') }}"
                class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-4">
                @csrf

                <div>
                    <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Title :</label>
                    <input name="title" class="w-full rounded border-gray-300" required>
                </div>

                <div>
                    <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Content :</label>
                    <textarea name="content" rows="6" class="w-full rounded border-gray-300" required></textarea>
                </div>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Save
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
