<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = (int)$this->command->ask('How many users would you like?', 20);

        if($usersCount < 1)
        {
            $this->command->info('There has to be a least one user');
            $this->command->info('Adding 1 user to DB');
        }

        factory(App\User::class)->states('jd')->create();
        factory(App\User::class, $usersCount)->create();
    }
}
