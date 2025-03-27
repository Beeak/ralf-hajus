<!DOCTYPE html>
<html>
<head>
    <title>All Markers</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .page-layout {
            display: flex;
            flex-wrap: wrap;
        }
        .sidebar {
            flex: 0 0 30%;
            min-width: 300px;
            max-height: 700px;
            overflow-y: auto;
            padding-right: 20px;
        }
        .map-container {
            flex: 0 0 70%;
        }
        #map {
            height: 700px;
            width: 100%;
        }
        .marker-list {
            list-style: none;
            padding: 0;
        }
        .marker-item {
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .marker-item:hover {
            background-color: #f5f5f5;
        }
        .marker-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .marker-description {
            color: #666;
            margin-bottom: 10px;
        }
        .marker-coords {
            font-size: 12px;
            color: #888;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #4285F4;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            display: none;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div id="form-container" class="form-container">
            <h3>Add New Marker</h3>
            <form id="marker-form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Marker</button>
                    <button type="button" class="btn btn-danger" id="cancel-btn">Cancel</button>
                </div>
            </form>
        </div>

        <div class="page-layout">
            <div class="sidebar">
                <h2>Markers List</h2>
                @if(count($markers) > 0)
                    <ul class="marker-list">
                        @foreach($markers as $marker)
                            <li class="marker-item" data-id="{{ $marker->id }}" data-lat="{{ $marker->latitude }}" data-lng="{{ $marker->longitude }}">
                                <div class="marker-name">{{ $marker->name }}</div>
                                <div class="marker-description">{{ $marker->description }}</div>
                                <div class="marker-coords">Lat: {{ $marker->latitude }}, Lng: {{ $marker->longitude }}</div>
                                <div class="marker-actions">
                                    <a href="{{ route('markers.edit', $marker->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('markers.destroy', $marker->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this marker?')">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No markers found. Click on the map to add a marker.</p>
                @endif
            </div>
            
            <div class="map-container">
                <div id="map"></div>
            </div>
        </div>
    </div>
    
    <script>
        let map;
        let tempMarker = null;
        let markers = @json($markers);
        let googleMarkers = {};
        
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 58.311890476343, lng: 22.941675910598 },
                zoom: 4,
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
        }
        
        function addMarkerToMap(markerData) {
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
                    <div>
                        <h3>${markerData.name}</h3>
                        <p>${markerData.description}</p>
                    </div>
                `
            });
            
            googleMarker.addListener('click', () => {
                infoWindow.open(map, googleMarker);
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.api_key') }}&callback=initMap">
    </script>
</body>
</html>