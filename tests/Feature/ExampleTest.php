<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /**
     * Test if the environment is correct
     */
    public function test_correct_testing_env(): void
    {
        self::assertNotEquals("db_manajemen_transaksi", env('DB_DATABASE'));
    }
}
