<?php

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Mohamed Zayed',
            'email' => 'mohamed.zayed@app.com',
            'password' => Hash::make("123456"),
            'remember_token' => Str::random(10),
        ]);

        $user->addresses()->save(
            factory(Address::class)->create([
                'user_id' => $user->id,
            ])
        );

        $user->addresses()->save(
            factory(Address::class)->create([
                'user_id' => $user->id,
            ])
        );

        factory(User::class, 4)->create();
    }
}
