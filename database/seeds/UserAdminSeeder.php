<?php

use App\Model\Guard\UserAdmin; 
use Illuminate\Database\Seeder; 

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        if(UserAdmin::count() == 0){
            DB::table('user_admin')->insert([
                'name' => 'Super Admin',
                'email' => 'developer2@webtecz.com',
                'phone' => '9814138141',
                'whats_app' => '9814138141',
                'phone_country_code_id' => 99,
                'whats_app_country_code_id' => 99,
                'status' => 1,
                'guard_id' => 1,
            ]);
            // UserAdmin::create([
            //     'name' => 'Super Admin',
            //     'email' => 'developer2@webtecz.com',
            //     'phone' => '9814138141',
            //     'whats_app' => '9814138141',
            //     'phone_country_code_id' => 99,
            //     'whats_app_country_code_id' => 99,
            //     'status' => 1,
            //     'guard_id' => 1,
            // ]);

        } 
    }
}
