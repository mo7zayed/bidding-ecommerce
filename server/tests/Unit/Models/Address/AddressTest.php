<?php

namespace Tests\Unit\Models\Users;

use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Tests\TestCase;

class AddressTest extends TestCase
{
    public function test_it_belongs_to_country()
    {
        $address = factory(Address::class)->create();

        $this->assertInstanceOf(Country::class, $address->country);
    }

    public function test_it_belongs_to_user()
    {
        $address = factory(Address::class)->create();

        $this->assertInstanceOf(User::class, $address->user);
    }

    public function test_it_updates_old_addresses_to_not_default()
    {
        $user = factory(User::class)->create();

        for ($i=0; $i < 5; $i++) {
            factory(Address::class)->create([
                'user_id' => $user->id,
                'default' => 1,
            ]);
        }

        $this->assertEquals(1, $user->addresses()->where('default', 1)->count());
    }
}
