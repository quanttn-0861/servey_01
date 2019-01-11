<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        User::truncate();
        factory(User::class)->create([
            'email' => 'admin@gmail.com',
            'name' => 'Admin',
            'level' => config('users.level.admin'),
        ]);

        factory(User::class)->create([
            'email' => 'supperadmin@gmail.com',
            'name' => 'Supper Admin',
            'level' => config('users.level.admin'),
        ]);

        factory(User::class, 10)->create();
    }
}
