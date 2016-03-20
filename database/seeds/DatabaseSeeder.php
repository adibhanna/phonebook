<?php

use Illuminate\Database\Seeder;
use PhoneBook\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(ContactsTableSeeder::class);
    }
}

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}

class ContactsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::first();
        $user1->contacts()->insert([
            ['name'=>'contact1-user1', 'phone' => '0342213123', 'notes' => 'some notes ...'],
            ['name'=>'contact2-user1', 'phone' => '0342213123', 'notes' => 'some notes ...'],
            ['name'=>'contact3-user1', 'phone' => '0342213123', 'notes' => 'some notes ...'],
            ['name'=>'contact4-user1', 'phone' => '0342213123', 'notes' => 'some notes ...'],
        ]);
    }
}
