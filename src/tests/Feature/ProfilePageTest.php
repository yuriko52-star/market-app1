<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class ProfilePageTest extends TestCase
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
    public function testProfilePageDisplaysInitialValues()
    {
        $user = User::factory()->create([
            'name' => '桃太郎侍',
        ]);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'img_url' => '/storage/images/test-user.jpg',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '渋谷タワー10F',
        ]);
         $response = $this->actingAs($user)->get(route('profile.edit', $user->id));
          $response->assertStatus(200);
          $response->assertSee('桃太郎侍');
        $response->assertSee('test-user.jpg'); 
        $response->assertSee('123-4567'); 
        $response->assertSee('東京都渋谷区'); 
        $response->assertSee('渋谷タワー10F'); 
    }
}
