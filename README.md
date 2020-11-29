Average temperature forecast
======

A simple Laravel application that calculates the average temperature forecast for a given city.
The form includes `City` field validation, which can also be clarified with State. The `Country` field should contain a valid ISO 3166 international standard Alpha-2 code.
Results are stored in the cache for two hours.

#### Examples
| City | Country |
|------|:-------:|
| Paris | FR |
| Paris, ME | US |
| Paris, Idaho | US |
 
Requirements
------------

- PHP >= 7.3
- Nginx

Installation
------------

#### Installing project

- Clone this repository
- Create and fill `.env` file from `.env.example`
- In project folder run `composer install`

Weatherbit
----------

Project uses [Weatherbit.io](https://www.weatherbit.io/) for retrieving 10 Day Weather Forecast.
[Weather API Documentation](https://www.weatherbit.io/api) to setup and configure
its API account credentials should be setup via `WEATHERBIT_API_KEY` environment variable. 
Create or get [API key](https://www.weatherbit.io/account/dashboard).

Testing
-------

#### Unit tests

Run Unit tests:

```
cd /project/root
phpunit
```
