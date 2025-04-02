<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('blog.index') }}" class="text-blue-500 hover:underline">&larr; Back to posts</a>
                    </div>
                    
                    <article class="prose dark:prose-invert max-w-none">
                        <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                        
                        <div class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                            Posted by: {{ $post->user ? $post->user->name : 'Unknown User' }}
                            <span class="ml-2">{{ $post->created_at->format('F j, Y, g:i a') }}</span>
                        </div>
                        
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($post->description)) !!}
                        </div>
                    </article>
                    
                    @if(Auth::check() && (Auth::id() === ($post->user_id ?? 0) || Auth::user()->role === 'admin'))
                        <div class="mt-8 flex space-x-4">
                            <a href="{{ route('blog.edit', $post->id) }}" 
                               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Edit Post
                            </a>
                            
                            <form method="POST" action="{{ route('blog.destroy', $post->id) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>