<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $aircraft->title }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('aircraft.index') }}" class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('aircraft.edit', $aircraft) }}" class="inline-flex items-center px-3 py-1 bg-yellow-100 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 rounded-md text-sm font-medium text-yellow-700 dark:text-yellow-300 hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            @if($aircraft->image)
                                <img src="{{ $aircraft->image_url }}" alt="{{ $aircraft->title }}" class="w-full h-auto rounded-lg shadow-md">
                            @else
                                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aircraft Details</h3>
                                <div class="mt-3 grid grid-cols-1 gap-2">
                                    <div class="py-2 border-b border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Type:</span>
                                        <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $aircraft->type }}</span>
                                    </div>
                                    <div class="py-2 border-b border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Aircraft Type:</span>
                                        <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $aircraft->aircraft_type }}</span>
                                    </div>
                                    <div class="py-2">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created:</span>
                                        <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $aircraft->created_at->format('F j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $aircraft->title }}</h3>
                            <div class="prose dark:prose-invert max-w-none">
                                <p class="text-gray-700 dark:text-gray-300">{{ $aircraft->description }}</p>
                            </div>
                            <div class="mt-6 flex space-x-3">
                                <a href="{{ route('aircraft.edit', $aircraft) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-medium text-white hover:bg-yellow-600 active:bg-yellow-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Aircraft
                                </a>
                                <form action="{{ route('aircraft.destroy', $aircraft) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this aircraft?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 active:bg-red-800 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Aircraft
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>