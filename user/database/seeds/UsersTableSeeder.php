<?php

use Illuminate\Database\Seeder;


use App\Models\User;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        try {
            $test = \DB::transaction(function () {

                $test = array();
                for ($n = 1; $n < 10; $n++) {

                    $user = new User(
                        [
                            // customer info
                            'name' => "test{$n}",
                            'password' => '111111',
                            'status' => User::STATUS_NORMAL,
                            'type' => $n%2==0 ? User::TYPE_NORMAL : User::TYPE_TEST,
                            'nick_name' => "testBusiness{$n}",
                            'mobile' => "1456467426{$n}",
                            'email' => "test{$n}@business.com",
                            'email_confirmed' => true,


                        ]);
                    $user->save();

                }

                return $test;

            }, 5);

        } catch (\Exception $e) {

            dump($e->getCode());
            dump($e->getMessage());
        };




        $user = new User(
            [
                // customer info
                'name' => "michael",
                'password' => '111111',
                'status' => User::STATUS_NORMAL,
                'type' => User::TYPE_NORMAL,
                'mobile' => "18616325540",
                'email' => "hbj418@gmail.com",

            ]);
        $user->save();





    }
}
