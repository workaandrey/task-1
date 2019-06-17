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
        factory(App\Country::class, 4)->create();
        factory(App\Country::class, 1)->create(['name' => 'Canada']);

        factory(App\Company::class, 50)->create();

        factory(App\User::class, 500)->create();

        $companies = App\Company::all();

        App\User::all()->each(function ($user) use ($companies) {
            $user->companies()->attach(
                $companies->random(rand(1, 3))->pluck('id')->toArray(),
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        });
    }
}
