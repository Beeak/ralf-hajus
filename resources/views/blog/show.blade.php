<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate mr-4">
                {{ $post->title }}
            </h2>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white dark:text-blue-400 bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Blog
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Post Header -->
                    <div class="border-b pb-4 mb-6 dark:border-gray-700">
                        <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-gray-100">{{ $post->title }}</h1>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                        {{ $post->user ? $post->user->name : 'Unknown User' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Published {{ $post->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                            </div>
                            
                            @if(Auth::check() && (Auth::id() === ($post->user_id ?? 0) || Auth::user()->role === 'admin'))
                                <div class="flex space-x-2">
                                    <a href="{{ route('blog.edit', $post->id) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-500 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit Post
                                    </a>
                                    
                                    <form method="POST" action="{{ route('blog.destroy', $post->id) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-2 border border-red-300 dark:border-red-700 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Delete Post
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    <article class="prose dark:prose-invert max-w-none mb-10">
                        {!! nl2br(e($post->description)) !!}
                    </article>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-6 border-b pb-3 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                            </svg>
                            <span>Comments ({{ $post->comments->count() }})</span>
                        </div>
                    </h2>
                    
                    @auth
                        <div class="mb-8 bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('blog.comments.store', $post->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Add a comment</label>
                                    <textarea name="content" id="content" rows="3" 
                                              class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800"
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg border border-blue-100 dark:border-blue-800">
                            <p class="flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                Please <a href="{{ route('login') }}" class="font-bold hover:underline">log in</a> to post comments.
                            </p>
                        </div>
                    @endauth
                    <div class="space-y-4">
                        @forelse($post->comments()->with('user')->latest()->get() as $comment)
                            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-medium text-gray-800 dark:text-gray-200">{{ $comment->user->name ?? 'Unknown User' }}</h4>
                                                <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="mt-1 text-gray-600 dark:text-gray-300">{!! nl2br(e($comment->content)) !!}</div>
                                        </div>
                                    </div>
                                    
                                    @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->role === 'admin'))
                                        <form method="POST" action="{{ route('blog.comments.destroy', [$post->id, $comment->id]) }}"
                                              onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>