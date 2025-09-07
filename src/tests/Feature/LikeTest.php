<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
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
    public function testUserCanLikeAnItem() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('toggle-like',['item' => $item->id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals(1, Like::where('item_id',$item->id)->count());
        $response = $this->actingAs($user)->get(route('item.show', ['item' => $item->id]));
        $response->assertSee('likes-overlay liked');
    }

    public function testLikecountIncreasesWhenUserLikesAnItem()
     {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post(route('toggle-like', ['item' => $item->id]));

        $response = $this->actingAs($user)->get(route('item.show', ['item' => $item->id]));

        $response->assertSee('1');
    }

    public function testUserCanUnlikeAnItem() 
    {
         $user = User::factory()->create();
         $item = Item::factory()->create();

        $this->actingAs($user)->post(route('toggle-like', ['item' => $item->id]));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)->post(route('toggle-like', ['item' => $item->id]));

        $this->assertDatabaseMissing('likes',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get(route('item.show', ['item' => $item->id]));
        $response->assertDontSee('ikes-overlay liked');
    }

    public function testLikecountDecreasesWhenUserUnlikesAnItem()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user)->post(route('toggle-like', ['item' => $item->id]));

        $this->actingAs($user)->post(route('toggle-like', ['item' => $item->id]));

        $response = $this->actingAs($user)->get(route('item.show', ['item' => $item->id]));

        $response->assertSee('0');
    }

    public function testGuestCanLikeAnItemAndStoreInSession()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('toggle-like', ['item' => $item->id]));

        $response->assertRedirect();

        $this->assertContains($item->id, session('guest_likes', []));
    }
}
