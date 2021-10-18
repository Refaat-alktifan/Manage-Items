<?php

use App\User;
use App\Settings;
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
        User::create( [
            'id'=>1,
            'name'=>'admin admin',
            'email'=>'info@admin.com',
            'department'=>'test,test2',
            'is_admin'=>1,
            'password'=>'$2y$10$dhT9K/PJCJO7fdA4CaEoM.3AWwTPgMDhIc80y8RSwGRgbZk9xIpnK',
            'remember_token'=>'X9P7ApHdwGoNGdIrBMiqfjlsiYXs2SbyImDlqt7vFHhbbKmkJiKbXE1ev2yp',
            'created_at'=>'2021-10-15 09:51:36',
            'updated_at'=>'2021-10-15 09:51:36'
        ] );

        Settings::create( [
            'id'=>1,
            'name'=>'department',
            'value'=>'test,test2'
        ] );

        Settings::create( [
            'id'=>3,
            'name'=>'from',
            'value'=>'info@admin.com'
        ] );


        // $this->call(UsersTableSeeder::class);
    }
}
