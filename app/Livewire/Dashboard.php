<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Http;

use Livewire\Component;

class Dashboard extends Component
{
    public $city;
    public $apiKey;
    public $data = null;
    public $forecastData;

    public function mount()
    {
        $this->apiKey = env('Open_Weather_KEY');
    }

    public function retreveWeatherFromAPI(string $city, string $cate){
        try{
            if($cate === "current"){
                $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$this->apiKey}";
            }else{
                $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&units=metric&appid={$this->apiKey}";
            }
            $resopnse = Http::get($apiUrl);
            return $resopnse->json();
        } catch (\Exception $e) {
            if($e->getCode() === 429){
                flash()->flash("Error", "Your API request limit has been exceeded!");
            }else{
                flash()->flash("Error", "Error retriving data from the API");
            }
        }
    }

    public function changeCity($city){
        if ($city === "colombo"){
            $this->data = $this->retreveWeatherFromAPI("Colombo", "current");
            $this->forecastData = $this->retreveWeatherFromAPI('Colombo', 'forecast');
        }else if ($city == "london"){
            $this->data = $this->retreveWeatherFromAPI("London", "current");
            $this->forecastData = $this->retreveWeatherFromAPI('London', 'forecast');
        }else if ($city === "new york"){
           $this->data = $this->retreveWeatherFromAPI("New York", "current");
            $this->forecastData = $this->retreveWeatherFromAPI('New York', 'forecast');
        }else if ($city === "tokyo"){
            $this->data = $this->retreveWeatherFromAPI("Tokyo", "current");
            $this->forecastData = $this->retreveWeatherFromAPI('Tokyo', 'forecast');
        }else if ($city === "dubai"){
            $this->data = $this->retreveWeatherFromAPI("Dubai", "current");
            $this->forecastData = $this->retreveWeatherFromAPI('Dubai', 'forecast');
        }else{
            $this->data = $this->retreveWeatherFromAPI("Colombo", "current");
            $this->forecastData = $this->retreveWeatherFromAPI('Colombo', 'forecast');
        }
    }

    public function getImageByWeather($data){
        if ($data["weather"][0]['main'] == "Clear"){
            return asset('images/sunny.png');
        }else if ($data["weather"][0]['main'] == "Clouds"){
            return asset('images/cloudy.png');
        }else if ($data["weather"][0]['main'] == "Rain"){
            return asset("images/rain.png");
        }else if ($data["weather"][0]['main'] == "Thunderstorm"){
            return asset('images/thunder.png');
        }else if ($data["weather"][0]['main'] == "Snow"){
            return asset('images/snow.png');
        }else if ($data["weather"][0]['main'] == "Drizzle"){
            return asset('images/drizzel.png');
        }else if ($data["weather"][0]['main'] == "Atmosphere"){
            return asset('images/atmosphere.png');
        }else if ($data["weather"][0]['main'] == "Mist"){
            return asset('images/mist.png');
        }else if ($data["weather"][0]['main'] == "Extreme"){
            return asset('images/tornado.png');
        }
    }

    public function getTodayForecast($forecastData){
        $currentDate = date("Y-m-d");
        $todaysForecast = [];
        foreach($forecastData['list'] as $forecast){
            $forecastDate = date("Y-m-d", strtotime($forecast['dt_txt']));
            if($forecastDate === $currentDate){
                $todaysForecast[] = $forecast;
            }
        }
        return $todaysForecast;
    }

    public function getFutureForecast($forecastData){
        $currentDate = date("Y-m-d");
        $todaysForecast = [];
        foreach($forecastData['list'] as $forecast){
            $forecastDate = date("Y-m-d", strtotime($forecast['dt_txt']));
            if($forecastDate >= $currentDate){
                $futureForecast[$forecastDate] = $forecast;
            }
        }
        return $futureForecast;
    }

    public function render()
    {
        if($this->data == null){
            $this->changeCity("default");
        }
        $data = $this->data;
        $weatherImg = $this->getImageByWeather($data);
        $forecastData = $this->forecastData;
        $todaysForecast = $this->getTodayForecast($forecastData);
        $futureForecast = $this->getFutureForecast($forecastData);
        return view('livewire.dashboard', compact('data', 'weatherImg', "todaysForecast", "futureForecast"));
    }
}
