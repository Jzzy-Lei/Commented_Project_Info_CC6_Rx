<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Portfolio Project') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">{{ $project->name }}</h1>
            <p class="text-gray-500 text-lg">{{ $project->category }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            @if ($project->images->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($project->images as $image)
                        <div class="overflow-hidden rounded-lg shadow-lg">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $project->name }}" class="w-full h-auto object-cover transition-transform duration-300 hover:scale-105">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No images available for this project.</p>
            @endif

            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Project Description</h2>
                <p class="text-gray-600 leading-relaxed">{{ $project->description }}</p>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 text-lg font-medium rounded-lg shadow hover:bg-blue-700 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
