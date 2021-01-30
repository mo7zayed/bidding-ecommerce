<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class MeTest extends TestCase
{
    public function test_user_can_not_get_his_data_untill_he_is_logged_in()
    {
        $response = $this->json('POST', 'api/auth/me');

        $response->assertStatus(401);
    }

    public function test_user_can_get_his_data()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/auth/me');

        $response->assertStatus(200);
        
        $response->assertJsonFragment([
            'email' => $user->email,
        ]);
    }
}
