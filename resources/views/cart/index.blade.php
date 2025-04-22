<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Shopping Cart') }}
            </h2>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-white dark:bg-gray-700 border-l-4 border-green-500 dark:border-green-400 mb-6 p-4 rounded-lg shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 dark:text-green-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border-l-4 border-red-500 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 dark:text-red-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Your Cart Items</h3>
                    
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach(session('cart') as $id => $details)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                            {{ $details['name'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div style="color: #2563eb;" class="text-sm text-blue-600 dark:text-blue-400 font-medium">${{ number_format($details['price'], 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update') }}" method="POST" class="flex">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" 
                                                        class="w-16 rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-300">
                                                    <button type="submit" style="border-color: #d1d5db" class="ml-2 px-3 py-1 text-xs border rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 transition-all duration-300 hover:shadow-md">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-green-600 dark:text-green-400">${{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove') }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-all duration-300 transform hover:scale-105">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-8 border-t pt-6 border-gray-200 dark:border-gray-700">
                            <div class="flex flex-wrap justify-between items-center">
                                <div class="flex items-center space-x-6 gap-2">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" style="border-color: #6b7280" class="border px-4 py-2 text-red-500 dark:text-red-400 rounded-md hover:bg-red-500 hover:text-white dark:hover:bg-red-700 transition-all duration-300">
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Clear Cart
                                            </span>
                                        </button>
                                    </form>
                                    
                                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                        Subtotal: <span class="text-blue-600 dark:text-blue-400">${{ number_format(array_sum(array_map(function($item) { 
                                            return $item['price'] * $item['quantity']; 
                                        }, session('cart'))), 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 sm:mt-0">
                                    <form action="{{ route('checkout.create') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-6 py-3 rounded-md font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Proceed to Checkout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="py-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Your cart is empty</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">Looks like you haven't added any products to your cart yet.</p>
                            <div class="mt-6">
                                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700">
                                    Browse Products
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>