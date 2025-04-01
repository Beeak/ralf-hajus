<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class WeatherController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = Config::get('services.openweather.key');
        $this->baseUrl = Config::get('services.openweather.base_url');
    }

    public function getWeather()
    {
        $cacheKey = 'weather_data';
        
        return Cache::remember($cacheKey, 1800, function () {
            $city = 'Tallinn';
            
            $response = Http::get("{$this->baseUrl}/2.5/weather", [
                'q' => $city,
                'appid' => $this->apiKey,
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