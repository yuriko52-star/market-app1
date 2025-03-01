<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginRequestTest extends TestCase
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
    public function testValidationFailsWhenRequiredFieldsAreEmpty()
    {
        $response = $this->postJson('/login',[]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email','password']);
    }

    public function testValidationFailsWithInvalidCredentials()
    {
        User::factory()->create([
            'email'=> 'test@example.com',
            'password'=> bcrypt('password1234'),
        ]);

        $response = $this->postJson('/login',[
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
    public function testUserCanLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password1234'),
        ]);

        $response = $this->postJson('/login',[
            'email' => 'test@example.com',
            'password' =>'password1234',
        ]);

        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }
}