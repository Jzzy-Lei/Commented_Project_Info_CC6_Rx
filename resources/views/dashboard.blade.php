<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-5 px-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Success Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif

                @if (session('destroy'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">{{ session('destroy') }}</strong>
                    </div>
                @endif

                @if (session('update'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">{{ session('update') }}</strong>
                    </div>
                @endif

                <!-- Add Portfolio Project Form -->
                <h3 class="text-lg font-medium mb-4">Create New Project Info</h3>
                <form method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-gray-700">Project Owner's Name</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="category" class="block text-gray-700">Project Name</label>
                            <input type="text" id="category" name="category"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        {{-- <div>
                            <label for="description" class="block text-gray-700">Description</label>
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                rows="3"></textarea>
                        </div> --}}
                    </div>
                    {{-- <div class="mt-4">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add
                            Project</button>
                    </div> --}}
                </form>
                <form id="feedbackForm" class="space-y-6">
                    {{-- <div>
                        <label for="name" class="block text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div> --}}

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email
                            Address</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Additional Details</label>
                        <textarea id="message" name="message" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Add something if you want to..."></textarea>
                    </div>

                    <div>
                        <button type="submit" id="submitButton"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span id="buttonText">Submit Project Details</span>
                            <span id="spinner" class="hidden">...</span>
                        </button>
                    </div>

                    <div id="responseMessage" class="hidden p-4 rounded-lg"></div>
                </form>

                <!-- Portfolio Projects -->
                <div class="my-8">
                    <h3 class="text-lg font-medium mb-4">Portfolio Gallery</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($projects as $project)
                            <div class="card border rounded-lg shadow">
                                <div class="grid grid-cols-2 gap-2 p-2">
                                    @forelse ($project->images ?? [] as $image)
                                        <img src="{{ asset('storage/' . $image->path) }}"
                                            alt="{{ $project->name }} Image" class="rounded-lg shadow-md">
                                    @empty
                                        <p class="col-span-2 text-gray-500 text-center">No images available.</p>
                                    @endforelse
                                </div>
                                <div class="p-4">
                                    <h5 class="font-bold text-lg">{{ $project->name }}</h5>
                                    <p class="text-sm text-gray-600">{{ $project->category }}</p>
                                    <p class="mt-2 text-gray-700">
                                        {{ \Illuminate\Support\Str::limit($project->description, 100) }}</p>
                                </div>
                                <div class="flex justify-between px-4 pb-4">
                                    <a href="{{ route('portfolio', $project->id) }}"
                                        class="text-blue-500 hover:text-blue-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 12h18M3 12l6 6M3 12l6-6" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('project.edit', $project->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.232 5.232l3.536 3.536M9 16.5L16.5 9m-3-3l-7.5 7.5H3v3.5l7.5-7.5z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('project.destroy', $project->id) }}"
                                        class="flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-3 text-gray-500">No projects available.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('spinner');
            const responseMessage = document.getElementById('responseMessage');

            submitButton.disabled = true;
            buttonText.textContent = 'Processing....';
            spinner.classList.remove('hidden');
            responseMessage.classList.add('hidden');

            const payload = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                message: document.getElementById('message').value
            };

            try {
                const response = await fetch('/feedback', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                responseMessage.classList.remove('hidden');
                if (response.ok && data.success) {
                    responseMessage.className = 'p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg';
                    responseMessage.innerHTML =
                        `<strong>Success!</strong> ${data.message} <div class="mt-2">We've sent a confirmation project details to ${payload.email}.</div>`;
                    this.reset();
                } else {
                    throw new Error(data.message || 'Failed to submit feedback');
                }
            } catch (error) {
                responseMessage.className = 'p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg';
                responseMessage.textContent = `Error: ${error.message}`;
                console.error('Submission error:', error);
            } finally {
                submitButton.disabled = false;
                buttonText.textContent = 'Submit Portfolio Details: ';
                spinner.classList.add('hidden');

                if (responseMessage.classList.contains('hidden') === false) {
                    setTimeout(() => {
                        responseMessage.classList.add('hidden');
                    }, 5000);
                }
            }
        })
    </script>

</x-app-layout>
