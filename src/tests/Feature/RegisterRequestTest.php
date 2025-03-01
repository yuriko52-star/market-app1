<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterRequestTest extends TestCase
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
        $response = $this->postJson('/register',[]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name','email','password']);
    }

    
    public function testValidationFailsWhenEmailIsMissing()
    {
        $response = $this->postJson('/register',[
            'name' =>'浦島太郎',
           
            'password' =>'password1234',
            'password_confirmation' => 'password1234',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['email']);
    }
    public function testValidationFailsWhenPasswordIsTooShort()
    {
        $response = $this->postJson('/register',[
            'name' =>'浦島太郎',
            'email'=> 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    public function testValidationFailsWhenPasswordDoseNotMatchConfirmation()
    {
        $response = $this->postJson('/register',[
            'name' =>'浦島太郎',
            'email'=> 'test@example.com',
            'password' => 'password1234',
            'password_confirmation' => 'differentpassword',
        ]) ;

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    } 

    public function testUserISRegisteredAndRedirectedToEmailVerify()
    {
        $response = $this->postJson('/register',[
            'name' =>'浦島太郎',
            'email'=> 'test@example.com',
            'password' => 'password1234',
            'password_confirmation' => 'password1234',
            ]);

            $this->assertDatabaseHas('users',[
                
                'name' =>'浦島太郎',
                'email'=> 'test@example.com',
            ]);

            $response->assertRedirect('/email/verify');
       
    }
}
