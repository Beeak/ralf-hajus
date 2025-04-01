<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class WeatherController extends Controller
{

    public function getWeather()
    {
        $apiKey = Config('services.openweather.key');
        $baseUrl = Config('services.openweather.base_url');
        
        return Cache::remember('weather_data', 1800, function () use ($apiKey, $baseUrl) {
            $city = 'Tallinn';
            
            $response = Http::get("{$baseUrl}/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);
            
            return $response->json();
        });
    }
    
    public function index()
    {
        $weatherData = $this->getWeather();
        return view('weather.index', compact('weatherData'));
    }
}