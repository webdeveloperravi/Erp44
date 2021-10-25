<?php

use App\Model\Guard\UserStore;
use Illuminate\Database\Seeder;

class UserStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(UserStore::count() == 0){
            UserStore::create([
                'name' => 'GemLab Super',
                'company_name' => 'GemLab',
                'email' => 'developer2@webtecz.com',
                'phone' => '9814138141',
                'whats_app' => '9814138141',
                'phone_country_code_id' => 99,
                'whats_app_country_code_id' => 99,
                'status' => 1,
                'guard_id' => 5,
                'store_role_id' => 13, 
                'type' => 'lab',  
            ]);

        }
    }
}
