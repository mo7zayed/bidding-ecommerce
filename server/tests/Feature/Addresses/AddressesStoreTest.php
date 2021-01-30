<?php

namespace Tests\Feature\Categories;

use App\Models\Address;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class AddressesStoreTest extends TestCase
{
    public function test_user_must_be_logged_in()
    {
        $response = $this->json('GET', 'api/addresses');

        $response->assertStatus(401);
    }

    public function test_it_accepts_only_valid_data()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/addresses');

        $response->assertJsonValidationErrors([
            'name',
            'country_id',
            'address_1',
            'city',
            'postal_code',
        ]);

        $response = $this->jsonAs($user, 'POST', 'api/addresses', [
            'country_id' => 0
        ]);

        $response->assertJsonValidationErrors([
            'country_id',
        ]);
    }

    public function test_it_accepts_only_valid_country()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/addresses', [
            'country_id' => 0
        ]);

        $response->assertJsonValidationErrors([
            'country_id',
        ]);
    }

    public function test_it_stores_the_valid_data()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
            'name' => 'Address 1',
            'country_id' => factory(Country::class)->create()->id,
            'address_1' => 'Address 1',
            'city' => 'Cairo',
            'postal_code' => '11511',
        ])->assertJsonFragment(array_except($payload, 'country_id'));

        $this->assertDatabaseHas('addresses', array_merge($payload, ['user_id' => $user->id]));
    }
}
