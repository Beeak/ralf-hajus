<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Weather Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Current Weather</h3>
                    
                    @if(isset($weatherData['main']))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col items-center justify-center">
                                <div class="weather-icon">
                                    @if(isset($weatherData['weather'][0]['icon']))
                                        <img src="https://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}@4x.png" 
                                             alt="Weather icon" class="w-32 h-32">
                                    @endif
                                </div>
                                <div class="mt-2 text-lg text-gray-600 dark:text-gray-300 capitalize">
                                    {{ $weatherData['weather'][0]['description'] ?? 'N/A' }}
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-center">
                                <div class="mb-2">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $weatherData['name'] ?? 'Unknown Location' }}
                                    </h3>
                                </div>
                                <div class="text-5xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ round($weatherData['main']['temp']) }}°C
                                </div>
                                <div class="text-gray-600 dark:text-gray-300">
                                    Feels like: {{ round($weatherData['main']['feels_like']) }}°C
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Humidity</div>
                                    <div class="text-2xl font-semibold text-blue-600 dark:text-blue-400">{{ $weatherData['main']['humidity'] ?? 'N/A' }}%</div>
                                </div>
                                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Wind</div>
                                    <div class="text-2xl font-semibold text-blue-600 dark:text-blue-400">{{ $weatherData['wind']['speed'] ?? 'N/A' }} m/s</div>
                                </div>
                                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pressure</div>
                                    <div class="text-2xl font-semibold text-blue-600 dark:text-blue-400">{{ $weatherData['main']['pressure'] ?? 'N/A' }} hPa</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Temperature Details</h4>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="text-gray-600 dark:text-gray-400">Min Temperature:</div>
                                    <div class="text-gray-900 dark:text-gray-200 font-medium">{{ $weatherData['main']['temp_min'] ?? 'N/A' }}°C</div>
                                    
                                    <div class="text-gray-600 dark:text-gray-400">Max Temperature:</div>
                                    <div class="text-gray-900 dark:text-gray-200 font-medium">{{ $weatherData['main']['temp_max'] ?? 'N/A' }}°C</div>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Sun Times</h4>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="text-gray-600 dark:text-gray-400">Sunrise:</div>
                                    <div class="text-gray-900 dark:text-gray-200 font-medium">
                                        @if(isset($weatherData['sys']['sunrise']))
                                            {{ date('H:i', $weatherData['sys']['sunrise']) }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                    
                                    <div class="text-gray-600 dark:text-gray-400">Sunset:</div>
                                    <div class="text-gray-900 dark:text-gray-200 font-medium">
                                        @if(isset($weatherData['sys']['sunset']))
                                            {{ date('H:i', $weatherData['sys']['sunset']) }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-xs text-gray-500 dark:text-gray-400 text-right">
                            Last updated: {{ date('F j, Y, g:i a') }}
                        </div>
                    @else
                        <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                        Weather data is currently unavailable.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>