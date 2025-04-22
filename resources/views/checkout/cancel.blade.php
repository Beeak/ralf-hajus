<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Payment Cancelled') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Payment Cancelled
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Your payment process was cancelled. Your cart items are still available.
                    </p>
                    
                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                            Return to Cart
                        </a>
                        <a href="{{ route('checkout.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700">
                            Try Again
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>