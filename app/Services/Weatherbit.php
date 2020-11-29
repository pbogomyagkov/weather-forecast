<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Weatherbit Service
 *
 * This service provide ability for retrieve weather observations
 *
 * @see https://www.weatherbit.io
 * @see https://www.weatherbit.io/api
 * @see https://www.weatherbit.io/api/swaggerui/weather-api-v2
 */
class Weatherbit
{
    const POSTFIX_FORECAST_DAILY = '/forecast/daily';

    /**
     * @var string API endpoint.
     */
    public $endpoint = '';

    /**
     * @var string API key.
     */
    public $key = '';

    /**
     * @var Client
     */
    protected $client;

    public function __construct(array $config = [])
    {
        foreach ($config as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * Returns a daily forecast
     *
     * @param string $city
     * @param string $country
     * @param int $days
     * @return
     */
    public function dailyForecast(string $city, string $country, $days = 10)
    {
        if (empty($this->key)) {
            throw new \Exception('Missing API Key');
        }

        $uri = $this->endpoint.self::POSTFIX_FORECAST_DAILY;
        list($city, $state) = array_pad(explode(',', $city, 2), 2,null);

        $parameters = [
            'city' => trim($city),
            'state' => trim($state),
            'country' => $country,
            'days' => $days,
            'key' => $this->key,
        ];

        $response = Http::get($uri.'?'.http_build_query($parameters));

        if ($response->failed()) {
            return 'n/a';
        }

        try {
            return collect($response->json()['data']);
        } catch (\Exception $e) {
            return 'n/a';
        }
    }

    /**
     * @param string $city
     * @param string $country
     * @param int $days
     * @return int
     */
    public function avgForecast(string $city, string $country, $days = 10)
    {
        $data = $this->dailyForecast($city, $country, $days);

        if (is_a($data, 'Illuminate\Support\Collection')) {
            return $data->pluck('temp')->avg();
        }

        return $data;
    }
}
