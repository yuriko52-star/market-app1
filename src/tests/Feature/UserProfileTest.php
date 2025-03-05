<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class UserProfileTest extends TestCase
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
    public function testUserProfileDisplaysCorrectlyOnMypage()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'img_url' => '/storage/images/test-user.jpg',
        ]);
        // $user->profile()->create([
            // 'img_url' => '/storage/images/test-user.jpg',
        // ]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('/storage/images/test-user.jpg');
    }

    public function testSellTabDisplaysListedItems()
    {
       $user = User::factory()->create();
       $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'img_url' => '/storage/images/test-user.jpg',
        ]);
       $item = Item::factory()->create([
        'user_id' => $user->id,
        'name' => 'テスト商品1',
        'img_url' => '/storage/images/test-product1.jpg',

       ]);
       $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'sell']));

       $response->assertStatus(200);
       $response->assertSee('テスト商品1');
       $response->assertSee('/storage/images/test-product1.jpg');
    }


    public function testBuyTabDisplaysPurchasedItems()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $buyer->id,
            'img_url' => '/storage/images/test-user.jpg',
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入した商品1',
            'img_url' => '/storage/images/buy-item.jpg', 
        ]);

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,

        ]);

        $response = $this->actingAs($buyer)->get(route('mypage', ['tab' => 'buy']));

        $response->assertStatus(200);
        $response->assertSee('購入した商品1');
        $response->assertSee('/storage/images/buy-item.jpg');
    }
}
