<?php

use Illuminate\Database\Seeder;
use App\Logins;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //Login
        DB::table('logins')->truncate();
        Logins::create(array(
        	'name'=> 'This is admin account',
        	'username' => 'admin',
        	'password' => bcrypt('admin123'),
        	'status' => 'Admin', 
        	));
        Logins::create(array(
        	'name'=> 'This is manager account',
        	'username' => 'manager',
        	'password' => bcrypt('manager123'),
        	'status' => 'Manager',
        	));
        Logins::create(array(
            'name'=>'This is DGPO Account',
            'username'=>'dgpo',
            'password'=>bcrypt('dgpo123'),
            'status'=>'DGPO'
        ));
        Logins::create(array(
            'name'=>'aplikasi_1',
            'username'=>'app1',
            'password'=>bcrypt('admin123'),
            'status'=>'adminBmdtp'
        ));
        Logins::create(array(
            'name'=>'aplikasi_2',
            'username'=>'app2',
            'password'=>bcrypt('admin123'),
            'status'=>'adminIjepa'
        ));
        Logins::create(array(
            'name'=>'aplikasi_3',
            'username'=>'app3',
            'password'=>bcrypt('admin123'),
            'status'=>'adminLcgc'
        ));
        $this->command->info('Login Added');
    }
}
