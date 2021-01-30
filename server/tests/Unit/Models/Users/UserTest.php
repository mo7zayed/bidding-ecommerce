<?php

namespace Tests\Unit\Models\Users;

use App\Models\Address;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_it_hashes_password_when_creating()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('123456'),
        ]);

        $this->assertNotEquals('123456', $user->password);
    }

    public function test_it_has_many_cart_products()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart()->first());
    }

    public function test_it_has_quantity_foreach_cart_product()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create(),
            ['quantity' => 5]
        );

        $this->assertEquals(5, $user->cart()->first()->pivot->quantity);
    }

    public function test_it_has_many_addresses()
    {
        $user = factory(User::class)->create();

        $user->addresses()->save(
            factory(Address::class)->create([
                'user_id' => $user->id
            ]),
        );

        $this->assertEquals(1, $user->addresses()->count());
    }
}
