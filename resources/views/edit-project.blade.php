<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Portfolio Project') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Edit Portfolio Project</h3>
                <form method="POST" action="{{ route('project.update', $project->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-gray-700">Project Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="category" class="block text-gray-700">Category</label>
                            <input type="text" id="category" name="category" value="{{ old('category', $project->category) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="images" class="block text-gray-700">Add New Screenshots/Images</label>
                            <input type="file" id="images" name="images[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>
                            <p class="text-sm text-gray-500 mt-1">You can upload multiple images.</p>
                        </div>

                        <div>
                            <label for="description" class="block text-gray-700">Description</label>
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('description', $project->description) }}</textarea>
                        </div>
                    </div>

                    @if ($project->images->isNotEmpty())
                    <div class="mt-4">
                        <h4 class="text-gray-700 mb-2">Current Images</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($project->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $project->name }}" class="w-full h-32 object-cover rounded-md shadow-sm">
                                    <label class="absolute top-1 right-1">
                                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="hidden">
                                        <span class="bg-red-600 text-white text-sm px-2 py-1 rounded cursor-pointer group-hover:block">Remove</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif


                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>