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
        $this->expectException(\Illuminate\Validation\ValidationException::class);
    
        $response = $this->post('/register',[]);
       }

    
    public function testValidationFailsWhenEmailIsMissing()
    {

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $response = $this->post('/register',[
            'name' =>'浦島太郎',
           
            'password' =>'password1234',
            'password_confirmation' => 'password1234',
        ]);
    }
    
    public function testValidationFailsWhenPasswordIsTooShort()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $response = $this->post('/register',[
            'name' =>'浦島太郎',
            'email'=> 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
    }

    public function testValidationFailsWhenPasswordDoseNotMatchConfirmation()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $response = $this->post('/register',[
            'name' =>'浦島太郎',
            'email'=> 'test@example.com',
            'password' => 'password1234',
            'password_confirmation' => 'differentpassword',
        ]) ;
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
