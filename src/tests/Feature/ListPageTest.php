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

        $myItems = Item::factory()->count(2)->create([
          'user_id' => $user->id,
          'img_url' => '/storage/images/testD.jpg'  ,
          'name' => 'My Item 1' 
        ]);

        $otherItems = Item::factory()->count(3)->create([
          'img_url' => '/storage/images/testE.jpg',
           'name' => 'Other Item'
        ]);

        $response = $this->actingAs($user)->get(route('list'));

      //  dd($response->getContent());

        foreach($myItems as $myItem) {
            $response->assertDontSee('My Item 1');
            $response->assertDontSee(asset($myItem->img_url));
        }
        foreach($otherItems as $item) {
          $expectedImageUrl = asset($item->img_url);
          $response->assertSee($item->name);
          
          $response->assertSee($expectedImageUrl);
        }
    }

    public function testSoldItemsAreMarkedAsSold()
    {
      $seller = User::factory()->create();

      $buyer = User::factory()->create();  

      $item = Item::factory()->create([
        'user_id' => $seller->id,
      ]);

      
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
      $user->profile()->create([
      'img_url' => 'images/test_profile.jpg',
      'post_code' => '123-4567', // 必須項目を指定
      'address' => 'Test Address',
      'building' => 'Test Building',
    ]);
      $this->actingAs($user);
      $item = Item::factory()->create([
        // 'name' => 'Armani Mens Clock',
        // 'img_url' => 'storage/images/Armani+Mens+Clock.jpg'
        'img_url' => 'images/test_image.jpg',
      ]);
        
      Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
      ]);
      // $purchasedItems = $user->purchases()->with('item')->get()->pluck('item');
      // file_put_contents(storage_path('logs/purchased_items.log'), print_r($purchasedItems->toArray(), true));

      // $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'buy']));
      $response = $this->get(route('mypage', ['tab' => 'buy']));
        // file_put_contents(storage_path('logs/response.html'), $response->getContent());
      // \Log::info('Response HTML:', ['html' => $response->getContent()]);
      // dump(asset('storage/images/Armani+Mens+Clock.jpg'));
     
      // $expectedImageUrl = asset( $item->img_url);

      /* $this->assertMatchesRegularExpression(
        '/<img\s+src="' . preg_quote($expectedImageUrl, '/') . '".*?>/',
        $response->getContent()
    );
    */
    $response->assertStatus(200);
    $response->assertSeeText($item->name);
      //  $response->assertSee($expectedImageUrl);
        $response->assertSee($item->img_url);
      // $response->assertSeeMatches('/<img\s+src=".*' . preg_quote($expectedImageUrl, '/') . '.*"/');
    }
      
}
