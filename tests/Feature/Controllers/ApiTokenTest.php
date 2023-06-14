<?php

namespace Tests\Feature\Controllers;

use App\Models\ApiToken;
use Tests\TestCase;

class apiTokenControllerTest extends TestCase
{
    public function test_can_generate_an_api_token()
    {

        $response = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response->assertStatus(200);

        $this->assertDatabaseHas('api_tokens', ['token' => $response->getContent()]);
    }

    public function test_can_not_generate_an_api_token_without_email()
    {

        $response = $this->post(route('apiToken'), []);

        $response->assertStatus(302);

        $this->assertDatabaseCount('api_tokens', 0);
    }

    public function test_can_generate_two_api_tokens_with_same_email()
    {
        $apiToken = ApiToken::factory()->create();

        $response = $this->post(route('apiToken'), ['email' => $apiToken->email]);

        $response->assertStatus(422);

        $this->assertDatabaseCount('api_tokens', 1);
    }
}
