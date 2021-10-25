<?php

use Illuminate\Database\Seeder;
use App\Model\Guard\UserWarehouse;

class UserWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(UserWarehouse::count() == 0){
            UserWarehouse::create([
                'name' => 'Warehouse Super',
                'email' => 'developer2@webtecz.com',
                'phone' => '9814138141',
                'whats_app' => '9814138141',
                'phone_country_code_id' => 99,
                'whats_app_country_code_id' => 99,
                'status' => 1,
                'guard_id' => 1,
            ]);

        }
    }
}
