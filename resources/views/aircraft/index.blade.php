<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Aircraft') }}
            </h2>
            <a href="{{ route('aircraft.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Aircraft
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Subjects from API</h3>
                    
                    <div id="subjects-container" class="mt-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex justify-between mb-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Loading subjects from external API...</p>
                            <button id="refresh-subjects" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                Refresh Data
                            </button>
                        </div>
                        <div id="subjects-data" class="overflow-x-auto">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">All Aircraft</h3>
                    
                    @if(count($aircraft) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aircraft Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($aircraft as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                    {{ $item->title }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->aircraft_type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('aircraft.show', $item) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                View
                                            </a>
                                            <a href="{{ route('aircraft.edit', $item) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300">
                                                Edit
                                            </a>
                                            <form action="{{ route('aircraft.destroy', $item) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this aircraft?')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No aircraft found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new aircraft.</p>
                        <div class="mt-6">
                            <a href="{{ route('aircraft.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New Aircraft
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchSubjectsData();
            
            document.getElementById('refresh-subjects').addEventListener('click', function() {
                fetchSubjectsData();
            });
            
            function fetchSubjectsData() {
                const subjectsContainer = document.getElementById('subjects-data');
                subjectsContainer.innerHTML = '<p class="text-center py-4">Loading...</p>';
                
                fetch('https://hajusrakendus.tak22jasin.itmajakas.ee/api/subjects')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        displaySubjectsData(data);
                    })
                    .catch(error => {
                        subjectsContainer.innerHTML = `<p class="text-red-500 text-center py-4">Error fetching data: ${error.message}</p>`;
                    });
            }
            
            function displaySubjectsData(data) {
                const subjectsContainer = document.getElementById('subjects-data');
                
                if (!data || data.length === 0) {
                    subjectsContainer.innerHTML = '<p class="text-center py-4">No subjects found</p>';
                    return;
                }
                
                let tableHtml = `
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Interest Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                `;
                
                data.forEach(subject => {
                    tableHtml += `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">${subject.id || 'N/A'}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                <div class="font-medium">${subject.title || 'N/A'}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-md truncate">${subject.description ? subject.description.substring(0, 100) + '...' : 'N/A'}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${subject.category || 'N/A'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    ${subject.interest_level === 'high' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 
                                    subject.interest_level === 'moderate' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : 
                                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'}">
                                    ${subject.interest_level || 'N/A'}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                ${subject.image ? 
                                    `<img src="${subject.image}" alt="${subject.title}" class="h-12 w-20 object-cover rounded">` : 
                                    'No image'}
                            </td>
                        </tr>
                    `;
                });
                
                tableHtml += `
                        </tbody>
                    </table>
                `;
                
                subjectsContainer.innerHTML = tableHtml;
            }
        });
    </script>
</x-app-layout>