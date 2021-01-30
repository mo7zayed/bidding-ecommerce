<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegisterationTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $response = $this->json('POST', 'api/auth/register');

        $response->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
        $response = $this->json('POST', 'api/auth/register');

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $response = $this->json('POST', 'api/auth/register', [
            'email' => 'any_mail',
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {
        factory(User::class)->create([
            'email' => 'user@domain.com',
        ]);


        $response = $this->json('POST', 'api/auth/register', [
            'email' => 'user@domain.com',
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $response = $this->json('POST', 'api/auth/register');

        $response->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_password_with_min_length_6()
    {
        $response = $this->json('POST', 'api/auth/register', [
            'password' => '123',
        ]);

        $response->assertJsonValidationErrors(['password']);
    }

    public function test_it_registers_a_user()
    {
        $response = $this->json('POST', 'api/auth/register', [
            'name' => 'Mohamed',
            'email' => 'mohamed@email.com',
            'password' => '123456',
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

        $this->assertDatabaseHas('users', [
            'email' => 'mohamed@email.com',
        ]);
    }
}
