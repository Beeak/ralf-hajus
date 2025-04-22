<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Products') }}
            </h2>
            <x-cart-popup />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden" style="height: 500px; min-height: 500px; max-height: 500px;">
                        <div class="flex flex-col" style="height: 100%;">
                            <div style="height: 300px; min-height: 300px; max-height: 300px; display: flex; align-items: center; justify-content: center;" class="w-full p-2">
                                @if($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" 
                                         style="max-height: 100%; max-width: 100%; object-fit: contain;" 
                                         alt="{{ $product->name }}">
                                @else
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <div style="height: 200px; display: flex; flex-direction: column;" class="p-4">
                                <div style="margin-bottom: 10px;">
                                    <h3 class="text-lg font-semibold mb-1 text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                                    <p style="color: #2563eb;" class="text-lg font-bold mb-2 dark:text-blue-400">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                </div>
                                <div style="margin-top: auto; display: flex; gap: 8px;">
                                    <a href="{{ route('shop.show', $product->id) }}" 
                                        style="flex: 1; display: inline-flex; justify-content: center; align-items: center; padding: 8px 12px; background-color: #f3f4f6; color: #374151; border-radius: 0.5rem; font-weight: 500; font-size: 0.875rem;"
                                        class="transition-all duration-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:shadow-md transform hover:-translate-y-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Details
                                    </a>
                                    <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" 
                                                style="width: 100%; display: inline-flex; justify-content: center; align-items: center; padding: 8px 12px; background-color: #2563eb; color: white; border-radius: 0.5rem; font-weight: 500; font-size: 0.875rem;"
                                                class="transition-all duration-300 hover:bg-blue-700 dark:hover:bg-blue-600 hover:shadow-md transform hover:-translate-y-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transition-transform duration-300 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>