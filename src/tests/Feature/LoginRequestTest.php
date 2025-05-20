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
        $this->expectException(\Illuminate\Validation\ValidationException::class);
       
        $response = $this->post('/login',[]);
      
    }

    public function testValidationFailsWithInvalidCredentials()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        User::factory()->create([
            'email'=> 'test@example.com',
            'password'=> bcrypt('password1234'),
        ]);

        $response = $this->post('/login',[
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

    }
    public function testUserCanLoginWithValidCredentials()
    {
        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password1234'),
        ]);

        $response = $this->post('/login',[
            'email' => 'test@example.com',
            'password' =>'password1234',
        ]);

        $response->assertStatus(302);

        $this->assertAuthenticatedAs($user);
    }
        
}