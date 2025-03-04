<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;

class AddressUpdateTest extends TestCase
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

    public function testUpdatedAddressIsReflectedInPurchasePage()
    {
        $user = User::factory()->create();
        $profile = $user->profile()->create([
        'address' => '東京都渋谷区',
        'post_code' => '123-4567',
        'building' => '渋谷タワー10F',
        'img_url' => '/storage/images/user-profile.jpg',
        ]);

        $item = Item::factory()->create();

        $purchase = Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address' => $profile->address,
            'shipping_post_code' => $profile->post_code,
            'shipping_building' => $profile->building,
            'payment_method' => 'card',
        ]);

        $this->assertDatabaseHas('purchases',[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address' => '東京都渋谷区',
            'shipping_post_code' => '123-4567',
            'shipping_building' => '渋谷タワー10F',
        ]);

        $newAddress = [
            'shipping_address' => '東京都新宿区',
            'shipping_post_code' => '147-2583',
            'shipping_building' => '新宿ビル6階',
        ];

        $response = $this->actingAs($user)->post(route('purchase.address.update', ['item_id' => $item->id]), $newAddress);

        $response->assertRedirect(route('purchase.show',['item_id' => $item->id]));
     
        $purchase->refresh();

        $this->assertDatabaseHas('purchases' ,[
             'user_id' => $user->id,
             'item_id' => $item->id,
             'shipping_address' => '東京都新宿区',
             'shipping_post_code' => '147-2583',
             'shipping_building' => '新宿ビル6階',
        ]);

        $response = $this->actingAs($user)->get(route('purchase.show', ['item_id' => $item->id]));

        $response->assertSee('東京都新宿区');
        $response->assertSee('147-2583');
        $response->assertSee('新宿ビル6階');
    }

    public function testAddressIsCorrectlySavedWhenPurchasingAfterupdate()
    {
        $user = User::factory()->create();

         $user->profile()->create([
            'address' => '東京都渋谷区',
            'post_code' => '123-4567',
            'building' => '渋谷タワー10F',
            'img_url' => '/storage/images/user-profile.jpg',
        ]);

         $item = Item::factory()->create();

         $updatedAddress = [
            'shipping_address' => '大阪市中央区',
            'shipping_post_code' => '543-8765',
            'shipping_building' => '大阪タワー20F',
         ];

          $response = $this->actingAs($user)->post(route('purchase.address.update', ['item_id' => $item->id]), $updatedAddress);
        //   dump($response->status());
        //  dump($response->content()); 
        $response->assertStatus(302);
        $response = $this->actingAs($user)->get(route('purchase.show', ['item_id' => $item->id]));
          $response->assertSee('大阪市中央区'); 
        $response->assertSee('543-8765');
        $response->assertSee('大阪タワー20F');

        //  dump(DB::table('purchases')->get());
        // dump($response->content());
           $this->actingAs($user)->post(route('purchase.store'), [
            'item_id' => $item->id,
            'payment_method' => 'card',
          ]);
          $purchase = Purchase::where('user_id',$user->id)->where('item_id',$item->id)->firstOrFail();

          $purchase->refresh();
        //   dd(DB::table('purchases')->get());
            dump(DB::table('purchases')->get());
          $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address' => '大阪市中央区',
            'shipping_post_code' => '543-8765',
            'shipping_building' => '大阪タワー20F',
             'payment_method' => 'card',
          ]);
    }



}
