<div x-data="{ cartOpen: false }" class="relative">
    <button @click="cartOpen = !cartOpen" class="relative flex items-center p-2 text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-md focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
        </svg>
        
        @if(session()->has('cart') && count(session('cart')) > 0)
            <span class="absolute -top-1 -right-1 bg-blue-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                {{ count(session('cart')) }}
            </span>
        @endif
    </button>
    
    <div x-show="cartOpen" 
         @click.away="cartOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50"
         style="display: none; width: 300px;">
        
        <div class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Your Cart</h3>
            <span class="text-sm text-gray-600 dark:text-gray-400">
                {{ session()->has('cart') ? count(session('cart')) : 0 }} items
            </span>
        </div>
        
        <div class="max-h-96 w-full overflow-y-auto">
            @if(session()->has('cart') && count(session('cart')) > 0)
                @foreach(session('cart') as $id => $details)
                    <div class="flex py-3 px-4 gap-2 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-20 flex-shrink-0 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden mr-4">
                            @if($details['image'])
                                <img src="{{ asset('images/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $details['name'] }}</h4>
                            <div class="flex justify-between items-center mt-1">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ $details['quantity'] }}</span>
                                    <p style="color: #2563eb;" class="text-sm font-semibold">${{ number_format($details['price'], 2) }}</p>
                                </div>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">
                    <svg style="width: 60px" xmlns="http://www.w3.org/2000/svg" class="mx-auto text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="mt-2">Your cart is empty</p>
                </div>
            @endif
        </div>
        
        @if(session()->has('cart') && count(session('cart')) > 0)
            <div class="py-3 px-4 bg-gray-50 dark:bg-gray-900">
                <div class="flex justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Subtotal:</span>
                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                        ${{ number_format(array_sum(array_map(function($item) { 
                            return $item['price'] * $item['quantity']; 
                        }, session('cart'))), 2) }}
                    </span>
                </div>
                <a href="{{ route('cart.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white text-center py-2 rounded-md text-sm font-medium transition-colors">
                    View Cart
                </a>
            </div>
        @endif
    </div>
</div>