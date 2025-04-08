<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Blog') }}
            </h2>
            @if(Auth::check())
                <a href="{{ route('blog.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Post
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="grid gap-6 md:grid-cols-1">
                        @forelse ($posts as $post)
                            <div class="overflow-hidden bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold mb-2">
                                        <a href="{{ route('blog.show', $post->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ Str::limit($post->description, 150) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="">
                                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                                    {{ $post->user ? $post->user->name : 'Unknown User' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <a href="{{ route('blog.show', $post->id) }}" 
                                               class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                                Read More
                                            </a>
                                            
                                            @if(Auth::check() && (Auth::id() === ($post->user_id ?? 0) || Auth::user()->role === 'admin'))
                                                <div class="flex space-x-1">
                                                    <a href="{{ route('blog.edit', $post->id) }}" 
                                                       class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                        Edit
                                                    </a>
                                                    <form class="inline" method="POST" action="{{ route('blog.destroy', $post->id) }}" 
                                                          onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-1 bg-red-100 dark:bg-red-900 rounded-md text-sm font-medium text-red-700 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No blog posts found</h3>
                                @if(Auth::check())
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new post.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('blog.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Create New Post
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>