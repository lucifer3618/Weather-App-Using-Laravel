<div class="contain-auto">
    <div class="cities" wire:ignore>
        <button class="city-btn selected" wire:click="changeCity('colombo')">Colombo</button>
        <button class="city-btn" wire:click="changeCity('new york')">New York</button>
        <button class="city-btn" wire:click="changeCity('tokyo')">Tokyo</button>
        <button class="city-btn" wire:click="changeCity('london')">London</button>
        <button class="city-btn" wire:click="changeCity('dubai')">Dubai</button>
    </div>
    <div wire:loading class="loading-overlay">
        <div class="inner-div">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading...">
            <p class="loading-text" style="color: white;">Loading...</p>
        </div>
    </div>

    <div class="info">
        <div class="data">
            <div class="details">
                <div class="main-data">
                    <div class="city-weather">
                        <div class="city-name">{{ $data['name'] }}</div>
                        <div class="chance"> {{ $data['weather'][0]['description'] }}</div>
                        <div class="temp">{{ round($data['main']['temp'], 1) }}&deg</div>
                    </div>
                    <div class="state-img">
                        <img src="{{ $weatherImg }}" class="" alt="" srcset="">
                    </div>
                </div>

                <div class="weather-breakdown">
                    <div class="title">TODAY'S FORECAST</div>
                    <div class="time-range">

                        @foreach ($todaysForecast as $range)
                            <div class="range">
                                <div class="time">{{ date("H:i", strtotime($range['dt_txt'])) }}</div>
                                <div class="time-img">
                                    <img src="http://openweathermap.org/img/wn/{{$range['weather'][0]['icon']}}@2x.png" alt="">
                                </div>
                                <div class="tempreture">{{ number_format($range['main']['temp'], 1) }} &degC</div>
                            </div>
                            <div class="vertical-line"></div>
                        @endforeach

                    </div>
                </div>

                <div class="air-condition">
                    <div class="heading">
                        <div class="title">AIR CONDITION</div>
                        <div class="see-more">
                            <button class="see-more-btn btn btn-primary">See More</button>
                        </div>
                    </div>
                    <div class="condition-data">

                        <div class="condition">
                            <i class="fa-solid fa-temperature-three-quarters"></i>
                            <div class="condition-info">
                                <div class="condition-name">Feels like</div>
                                <div class="condition-val">{{ number_format($data['main']['feels_like'], 1) }}&deg</div>
                            </div>
                        </div>

                        <div class="condition">
                            <i class="fa-solid fa-wind"></i>
                            <div class="condition-info">
                                <div class="condition-name">Wind Speed</div>
                                <div class="condition-val">{{ $data['wind']['speed'] }} m/s</div>
                            </div>
                        </div>

                        <div class="condition">
                            <i class="fa-solid fa-droplet"></i>
                            <div class="condition-info">
                                <div class="condition-name">Humidity</div>
                                <div class="condition-val">{{ $data['main']['humidity'] }}%</div>
                            </div>
                        </div>

                        <div class="condition">
                            <i class="fa-solid fa-cloud-sun"></i>
                            <div class="condition-info">
                                <div class="condition-name">Cloudiness</div>
                                <div class="condition-val">{{ $data['clouds']['all'] }}%</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="forecast">
                <h5 class="title">5-DAY FORECAST</h5>

                <div class="days">
                    @foreach ($futureForecast as $forecast)
                        <div class="day">
                            @if(date("Y-m-d", strtotime($forecast['dt_txt'])) == date('Y-m-d'))
                                <div class="day-name">Today</div>
                                @else
                                    <div class="day-name">{{ date("l", strtotime($forecast['dt_txt'])) }}</div>
                            @endif
                            <div class="forecast-img">
                                <img src="{{ $this->getImageByWeather($forecast) }}" class="img-fluid" alt="">
                            </div>
                            <div class="status">{{ $forecast['weather'][0]['main'] }}</div>
                            <div class="day-temp">{{ number_format($forecast['wind']['speed'], 1) }}ms<span>/{{ $forecast['wind']['deg'] }}&deg</span></div>
                        </div>
                        <hr>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


</div>
