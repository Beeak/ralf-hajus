<!DOCTYPE html>
<html>
<head>
    <title>Edit Marker</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #4285F4;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .button-group {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Marker</h1>
        
        <div class="card">
            <form method="POST" action="/markers/{{ $marker->id }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $marker->name }}" required>
                    @error('name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ $marker->description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" id="latitude" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ $marker->latitude }}" required>
                    @error('latitude')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" id="longitude" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ $marker->longitude }}" required>
                    @error('longitude')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        Update Marker
                    </button>
                    <a href="/markers" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>