<?php

use Illuminate\Database\Seeder;
use App\User;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new User;
        $administrator->username = 'hafizhindram';
        $administrator->name = 'Hafizh Indra';
        $administrator->email = 'hafizhindram@gmail.com';
        $administrator->roles = json_encode(["STAFF"]);
        $administrator->password = \Hash::make('semarang');

        $administrator->save();

        $this->command->info("User admin berhasil ditambahkan");
    }
}
