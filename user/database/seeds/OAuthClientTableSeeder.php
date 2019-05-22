<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.w
     *
     * @return void
     */
    public function run()
    {
        //


        \DB::table('oauth_clients')->insert([

            "user_id" => null,
            "name" => "MiniProgram System Client",
            "secret" => "55e1S2fTBnnKSykP72MxKZ1Vz9RNtHlpTfZeJs4o",
            "redirect" => "http://localhost",
            "personal_access_client" => 0,
            "password_client" => 0,
            "revoked" => 0,
        ]);

        \DB::table('oauth_clients')->insert([

            "user_id" => null,
            "name" => "MiniProgram User Password Client",
            "secret" => "65e1S2fTBnnKSykP72MxKZ1Vz9RNtHlpTfZeJs4o",
            "redirect" => "http://localhost",
            "personal_access_client" => 0,
            "password_client" => 1,
            "revoked" => 0,
        ]);

    }
}
