<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationWorks extends TestCase
{
    /**
     * test_if_application_is_working.
     *
     * @return void
     */
    public function test_if_application_is_working() : void
    {
        $response = $this->get('/');

        $response->assertSee("Welcome");

        $response->assertStatus(200);
    }
}
