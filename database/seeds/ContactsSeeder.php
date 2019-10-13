<?php

use App\User;
use App\Contact;
use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactsCount = (int)$this->command->ask('How many contacts would you like per user?', 5);

        User::all()
            ->each(function($user) use ($contactsCount) {
                $user->contacts()
                    ->saveMany(factory(Contact::class, $contactsCount)->make());
        });
    }
}
