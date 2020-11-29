<?php

namespace Tests\Unit;

use App\Services\Weatherbit;
use PHPUnit\Framework\TestCase;

class WeatherbitTest extends TestCase
{
    /**
     * Retrieve Avg Temp
     *
     * @return void
     */
    public function testRetrieveAvgTemp()
    {
        $service = new FakeWeatherbit([]);
        $city = 'Paris';
        $country = 'FR';
        $result = $service->avgForecast($city, $country);

        $this->assertEquals(20.5, $result);
    }
}

class FakeWeatherbit extends Weatherbit
{
    public function dailyForecast(string $city, string $country, $days = 10)
    {
        return [
            ['temp' => 10],
            ['temp' => 12],
            ['temp' => 30],
            ['temp' => 30],
        ];
    }
}
