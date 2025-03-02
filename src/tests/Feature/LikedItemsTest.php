<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikedItemsTest extends TestCase
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
    public function testLikedItemsAreDisplayedCorrectly()
    {
        $user = User::factory()->create();

        $items = Item::factory()->count(3)->create();

        $likedItems = $items->take(2);
        foreach ($likedItems as $item) {
            Like::factory()->create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }
        $notLikedItem = $items->diff($likedItems)->first();

        $response = $this->actingAs($user)->get(route('list',['tab' => 'mylist']));

        foreach ($likedItems as $item) {
            $response->assertSee($item->name);
            $response->assertSee($item->img_url);
        }
        // dd($response->getContent());
        // dd($notLikedItem);
        $response->assertDontSeeText($notLikedItem->name);
        $response->assertDontSeeText($notLikedItem->img_url);
    }

    public function testSoldItemsAreMarkedAsSold()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get(route('list', ['tab' => 'mylist']));

        $response->assertSee($item->name);
        $response->assertSee($item->img_url);

        $response->assertSee('Sold');
    }

    public function testUnauthenticatedUsersSeeNothingOnMylist()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get(route('list',['tab' => 'mylist']));

        foreach ($items as $item) {
            $response->assertDontSee($item->name);
            $response->assertDontSee($item->img_url);
        }
    }
}
