<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function jsonAs(JWTSubject $user, $method, $uri, array $data = [], array $headers = [])
    {
        $token = auth()->tokenById($user->id);

        $headers = array_merge($headers, [
            'Authorization' => "Bearer $token",
        ]);

        return $this->json($method, $uri, $data, $headers);
    }
}
