<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <x-cart-popup />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Products
                </a>
            </div>

            @if(session('success'))
                <div class="bg-white dark:border-green-400 dark:text-green-700 mb-6 p-4 border rounded-lg shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 dark:text-green-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 dark:text-red-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($product))
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/2 h-[400px] bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-4">
                            @if($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" 
                                     class="max-w-full max-h-full object-contain" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-24 h-24 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="md:w-1/2 p-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $product->name }}</h1>
                            <p style="color: #2563eb;" class="text-2xl font-bold dark:text-blue-400 mb-4">${{ number_format($product->price, 2) }}</p>
                            
                            <div class="prose dark:prose-invert max-w-none mb-6">
                                <p class="text-gray-600 dark:text-gray-300">{{ $product->description }}</p>
                            </div>
                            
                            <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center py-3 px-8 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-lg transition-all duration-300 font-medium shadow-md hover:shadow-lg text-lg transform hover:-translate-y-1 hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform duration-300 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-900 dark:text-gray-100">Product not found</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-300">The product you're looking for doesn't exist or has been removed.</p>
                    <div class="mt-6">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                            Return to Shop
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>