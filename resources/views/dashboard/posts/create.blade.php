<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <!-- IMPORTANT: enctype for images -->
                <form action="{{ route('dashboard.posts.store') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-bold">Title</label>
                        <input type="text"
                            name="title"
                            class="w-full border p-2 rounded"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Content</label>
                        <textarea name="content"
                            rows="5"
                            class="w-full border p-2 rounded"
                            required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Images (Select Multiple)</label>
                        <input type="file"
                            name="images[]"
                            multiple
                            class="w-full border p-2">
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Publish</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
