<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\State;
use App\City;
use App\DataProviders\CountryDataProvider;
use App\DataProviders\StateDataProvider;
use App\DataProviders\CityDataProvider;

class CountryStateCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insert(CountryDataProvider::data());
        State::insert(StateDataProvider::data());
        foreach (collect(CityDataProvider::data())->chunk(15000) as $chunkCities){
            City::insert($chunkCities->toArray());
        }
    }
}
