<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Map Markers') }}
            </h2>
        </div>
    </x-slot>
    
    <!-- Add Google Maps script directly in the page -->
    @push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.api_key') }}"></script>
    @endpush

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

            <!-- Make the map take up the full width for better visibility -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Map</h3>
                    <!-- Increase the height of the map -->
                    <div class="h-[700px] rounded-lg overflow-hidden border dark:border-gray-700" id="map"></div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-center">
                        Click anywhere on the map to add a new marker
                    </div>
                </div>
            </div>
            
            <div id="form-container" class="bg-white dark:bg-gray-800 mb-6 rounded-lg shadow-sm p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Add New Marker</h3>
                <form id="marker-form">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name:</label>
                        <input type="text" id="name" name="name" required
                               class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description:</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                            Save Marker
                        </button>
                        <button type="button" id="cancel-btn" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Markers List</h3>
                    
                    <div class="overflow-y-auto max-h-[500px] pr-2">
                        @if(count($markers) > 0)
                            <ul class="space-y-4">
                                @foreach($markers as $marker)
                                    <li class="marker-item border dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer" 
                                        data-id="{{ $marker->id }}" 
                                        data-lat="{{ $marker->latitude }}" 
                                        data-lng="{{ $marker->longitude }}">
                                        <div class="font-medium text-gray-900 dark:text-gray-200 text-base">{{ $marker->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $marker->description }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                                            Lat: {{ $marker->latitude }}, Lng: {{ $marker->longitude }}
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('markers.edit', $marker->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300">
                                                Edit
                                            </a>
                                            <form action="{{ route('markers.destroy', $marker->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this marker?')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No markers found</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Click on the map to add a new marker.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            document.querySelectorAll('.marker-item').forEach(item => {
                item.addEventListener('click', function() {
                    const lat = parseFloat(this.getAttribute('data-lat'));
                    const lng = parseFloat(this.getAttribute('data-lng'));
                    const id = this.getAttribute('data-id');
                    map.setCenter({lat: lat, lng: lng});
                    map.setZoom(15);
                    google.maps.event.trigger(googleMarkers[id], 'click');
                });
            });
            
            document.getElementById('cancel-btn').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('form-container').style.display = 'none';
                document.getElementById('marker-form').reset();
                
                if (tempMarker) {
                    tempMarker.setMap(null);
                    tempMarker = null;
                }
            });
            
            document.getElementById("marker-form").addEventListener("submit", function(e) {
                e.preventDefault();
                
                // Check if coordinates are set when not adding from map click
                if (!document.getElementById("latitude").value || !document.getElementById("longitude").value) {
                    alert("Please click on the map to select a location for your marker.");
                    return;
                }
                
                const formData = {
                    name: document.getElementById("name").value,
                    description: document.getElementById("description").value,
                    latitude: document.getElementById("latitude").value,
                    longitude: document.getElementById("longitude").value,
                };
                
                fetch("{{ route('markers.store') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addMarkerToMap(data.marker);
                        document.getElementById("marker-form").reset();
                        document.getElementById("form-container").style.display = "none";
                        
                        if (tempMarker) {
                            tempMarker.setMap(null);
                            tempMarker = null;
                        }
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error saving marker");
                });
            });
        });

        let map;
        let tempMarker = null;
        let markers = @json($markers);
        let googleMarkers = {};
        
        function initMap() {
            // Check if the map element exists
            const mapElement = document.getElementById("map");
            if (!mapElement) {
                console.error("Map element not found!");
                return;
            }
            
            try {
                map = new google.maps.Map(mapElement, {
                    center: { lat: 58.311890476343, lng: 22.941675910598 },
                    zoom: 6,
                    styles: window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? [
                        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
                        { featureType: "water", elementType: "geometry", stylers: [{ color: "#17263c" }] },
                        { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#515c6d" }] },
                        { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                    ] : []
                });
                
                markers.forEach(marker => {
                    addMarkerToMap(marker);
                });
                
                map.addListener("click", (event) => {
                    if (tempMarker) {
                        tempMarker.setMap(null);
                    }
                    
                    tempMarker = new google.maps.Marker({
                        position: event.latLng,
                        map: map,
                        animation: google.maps.Animation.DROP
                    });
                    
                    document.getElementById("latitude").value = event.latLng.lat();
                    document.getElementById("longitude").value = event.latLng.lng();
                    document.getElementById("form-container").style.display = "block";
                });
                
                console.log("Map initialized successfully!");
            } catch (error) {
                console.error("Error initializing map:", error);
            }
        }
        
        function addMarkerToMap(markerData) {
            if (!map) {
                console.error("Map not initialized!");
                return;
            }
            
            const googleMarker = new google.maps.Marker({
                position: { 
                    lat: parseFloat(markerData.latitude), 
                    lng: parseFloat(markerData.longitude) 
                },
                map: map,
                title: markerData.name
            });
            
            googleMarkers[markerData.id] = googleMarker;
            
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div class="p-2">
                        <div class="font-bold">${markerData.name}</div>
                        <p>${markerData.description}</p>
                    </div>
                `
            });
            
            googleMarker.addListener('click', () => {
                infoWindow.open(map, googleMarker);
            });
        }
    </script>
</x-app-layout>
