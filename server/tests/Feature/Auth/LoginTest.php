<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_it_requires_a_email()
    {
        $response = $this->json('POST', 'api/auth/login');

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'any_mail',
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $response = $this->json('POST', 'api/auth/login');

        $response->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_password_with_min_length_6()
    {
        $response = $this->json('POST', 'api/auth/login', [
            'password' => '123',
        ]);

        $response->assertJsonValidationErrors(['password']);
    }

    public function test_it_user_can_not_login_in_case_valid_cerdentials()
    {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'any_mail@domain.com',
            'password' => '123456', // because the default password is 123456
        ]);

        $response->assertJsonStructure([
            'status',
            'success',
            'payload' => [
                'message',
            ],
            'errors',
        ]);
    }

    public function test_it_logging_a_user()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $response = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => '123456', // because the default password is 123456
        ]);

        $response->assertJsonStructure([
            'status',
            'success',
            'payload' => [
                'access_token',
                'token_type',
                'expires_in',
            ],
            'errors',
        ]);
    }
}
