<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListPageTest extends TestCase
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

    public function testGuestCanViewAllItems()
    {
       Item::factory()->count (3)->create();

       $response = $this->get(route('list'));
    
       $items = Item::select('id','name','img_url')->get();
       $response->assertStatus(200);
       foreach($items as $item) {
            $response->assertSee($item->name);
            $response->assertSee($item->img_url);
       }
    }
      
    public function testLoggedInUserCanViewAllItemsExceptTheirOwn()
    {
        $user = User::factory()->create();
        Item::factory()->count(2)->create(['user_id' => $user->id]);

        $otherItems = Item::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('list'));
        $items = Item::select('id','name','img_url')
        ->where('user_id', '!=', $user->id)
        ->get();

        foreach($user->items as $myItem) {
            $response->assertDontSee($myItem->name);
            $response->assertDontSee($myItem->img_url);
        }
        foreach($otherItems as $item) {
          $response->assertSee($item->name);
          $response->assertSee($item->img_url);  
        }
    }

    public function testSoldItemsAreMarkedAsSold()
    {
      $seller = User::factory()->create();

      $buyer = User::factory()->create();  

      $item = Item::factory()->create([
        'user_id' => $seller->id,
      ]);

      // $purchase = $this->get(route('list'));
      Purchase::factory()->create([
        'user_id' => $buyer->id,
        'item_id' => $item->id,
      ]);
      $response = $this->get(route('list'));

      $response->assertSee($item->name);
      $response->assertSee($item->img_url);
      $response->assertSee('Sold');

    }

    public function testPurchasedItemsAreShownOnMypage()
    {
      $user = User::factory()->create();
      $item = Item::factory()->create();
        
      Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
      ]);

      $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'buy']));

      $response->assertSee($item->name);
      $response->assertSee($item->img_url);
    }
}
