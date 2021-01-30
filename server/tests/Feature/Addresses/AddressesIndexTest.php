<?php

namespace Tests\Feature\Categories;

use App\Models\Address;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

class AddressesIndexTest extends TestCase
{
    public function test_user_must_be_logged_in()
    {
        $response = $this->json('GET', 'api/addresses');

        $response->assertStatus(401);
    }

    public function test_it_returns_addresses_of_the_user()
    {
        $user = factory(User::class)->create();

        $user->addresses()->save(
            $address = factory(Address::class)->create([
                'user_id' => $user->id,
            ])
        );

        $response = $this->jsonAs($user, 'GET', 'api/addresses');

        $response->assertJsonFragment([
            'name' => $address->name,
        ]);
    }
}
