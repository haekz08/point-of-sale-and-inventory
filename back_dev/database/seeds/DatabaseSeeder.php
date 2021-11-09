<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //ADD ADMIN ROLES
        $arr = ['Super Admin', 'Administrator', 'Encoder'];
        foreach($arr as $row){
            \App\Role::create([
                'name' => $row,
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }

        //ADD SUPER ADMIN USER
        \App\User::create(['last_name' => 'Super Admin','first_name' => 'Super Admin','email' => 'a@a.com','password' => bcrypt('secret'),'role_id' => 1]);


        //ADD PAYMENT MODES
        $arr = ['CASH', 'CHECK', 'CREDIT MEMO', 'CHARGED'];
        foreach($arr as $row){
            \App\PaymentMode::create([
                'description' => $row,
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }

        //ADD STAFF ROLES
        $arr = ['Sales Representative', 'Cashier'];
        foreach($arr as $row){
            \App\StaffRole::create([
                'description' => $row,
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }

        //ADD TRANSACTION TYPE
        $arr = ['Starting Balance', 'Deposit', 'Disbursement'];
        foreach($arr as $row){
            \App\ReturnType::create([
                'description' => $row,
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }

    }
}
