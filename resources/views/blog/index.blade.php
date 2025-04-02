<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(Auth::check())
                        <div class="mb-4">
                            <a href="{{ route('blog.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create Post</a>
                        </div>
                    @endif
                    
                    @forelse ($posts as $post)
                        <div class="mb-4 p-4 border rounded">
                            <h3 class="text-lg font-bold">
                                <a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="mt-2">{{ Str::limit($post->description, 150) }}</p>
                            <div class="mt-2 text-sm text-gray-500">
                                Posted by: {{ $post->user ? $post->user->name : 'Unknown User' }}
                                <span class="ml-2">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @if(Auth::check() && (Auth::id() === ($post->user_id ?? 0) || Auth::user()->role === 'admin'))
                                <div class="mt-2">
                                    <a href="{{ route('blog.edit', $post->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('blog.destroy', $post->id) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p>No blog posts found.</p>
                    @endforelse
                    
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>