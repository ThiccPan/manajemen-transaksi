<?php

namespace Tests\Feature\Customer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InsertTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_insert_new_customer(): void
    {
        $user = User::factory()->create();
        $actingUser = $this->actingAs($user);

        $requestData = [
            "name" => "toko 1",
            "location" => "jalan jalan nomer 12",
        ];
        $response = $this->post(route('customers.insert'), $requestData);

        $response
            ->assertSessionHasNoErrors()
            ->dd();
    }
}
