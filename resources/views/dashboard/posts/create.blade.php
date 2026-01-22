<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">

                <!-- 1. Initialize Alpine Data for Previews -->
                <form action="{{ route('dashboard.posts.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    x-data="{
                        images: [],
                        handleFileSelect(event) {
                            this.images = []; // Clear previous
                            const files = event.target.files;
                    
                            // Convert FileList to Array and create URLs
                            Array.from(files).forEach(file => {
                                this.images.push({
                                    url: URL.createObjectURL(file),
                                    name: file.name
                                });
                            });
                        }
                    }">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Title
                        </label>
                        <input type="text"
                            name="title"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                            required>
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Content
                        </label>
                        <textarea name="content"
                            rows="5"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                            required></textarea>
                    </div>

                    <!-- Image Upload with Preview -->
                    <div class="mb-6">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Images (Select Multiple)
                        </label>

                        <!-- File Input -->
                        <input type="file"
                            name="images[]"
                            multiple
                            @change="handleFileSelect($event)"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded-md dark:text-gray-300 dark:bg-gray-900">

                        <!-- 2. The Preview Grid -->
                        <!-- Show this div only if images exist -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4"
                            x-show="images.length > 0"
                            x-cloak>
                            <template x-for="image in images">
                                <div class="relative group">
                                    <img :src="image.url"
                                        class="h-32 w-32 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition rounded-lg flex items-center justify-center">
                                        <p class="text-white text-xs truncate px-2"
                                            x-text="image.name">
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-md transition">
                        Publish Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
