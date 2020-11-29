<?php

namespace App\Http\Controllers;

use App\Services\Weatherbit;
use Illuminate\Http\Request;
use App\Http\Requests\ForecastDailyRequest;
use Illuminate\Support\Facades\Cache;

class ForecastController extends Controller
{
    /**
     * @var
     */
    protected $weatherbitService;

    public function __construct()
    {
        $this->weatherbitService = new Weatherbit(config('services.weatherbit'));
    }

    /**
     * validate request
     *
     * @param ForecastDailyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ForecastDailyRequest $request)
    {
        return redirect()->route('show', ['city' => $request->city, 'country' => $request->country]);
    }

    /**
     * Display the results
     *
     * @param string $city
     * @param string $country
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $city, string $country)
    {
        $city = urldecode($city);

        try {
            $request = new Request();
            $request['city'] = $city;
            $request['country'] = $country;

            $this->validate($request, [
                'city' => 'regex:/^[a-zA-Z,\s+]*$/',
                'country' => 'alpha|size:2',
            ]);
        } catch (\Exception $e) {
            return abort(404);
        }

        $key = strtolower(implode('_', [
            $city,
            $country,
        ]));
        $value = cache($key);

        if (is_null($value)) {
            $value = $this->weatherbitService->avgForecast(
                $city,
                $country
            );
            Cache::put($key, $value, now()->addHours(2));
        }

        return view('index', [
            'city' => $city,
            'country' => $country,
            'forecast' => $value
        ]);
    }
}
