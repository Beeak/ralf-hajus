views/weather/index.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }
        .weather-card {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            background-color: white;
            padding: 30px;
            margin-top: 50px;
        }
        .temp-display {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .weather-icon img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="weather-card">
                    <h1 class="text-center mb-4">Current Weather</h1>
                    
                    @if(isset($weatherData['main']))
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center">
                                <div class="weather-icon">
                                    @if(isset($weatherData['weather'][0]['icon']))
                                        <img src="https://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}@2x.png" alt="Weather icon">
                                    @endif
                                </div>
                                <div class="weather-description mt-2">
                                    {{ $weatherData['weather'][0]['description'] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="location">
                                    <h3>{{ $weatherData['name'] ?? 'Unknown Location' }}</h3>
                                </div>
                                <div class="temp-display">
                                    {{ round($weatherData['main']['temp']) }}°C
                                </div>
                                <div class="feels-like">
                                    Feels like: {{ round($weatherData['main']['feels_like']) }}°C
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-4 text-center">
                                <div class="fw-bold">Humidity</div>
                                <div>{{ $weatherData['main']['humidity'] ?? 'N/A' }}%</div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="fw-bold">Wind</div>
                                <div>{{ $weatherData['wind']['speed'] ?? 'N/A' }} m/s</div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="fw-bold">Pressure</div>
                                <div>{{ $weatherData['main']['pressure'] ?? 'N/A' }} hPa</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Weather data is currently unavailable.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>