<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
     */
    public function testUserCanLogout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password1234'),
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/logout');

        $response->assertStatus(204);

        $this->assertGuest();

    }
}
