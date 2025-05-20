<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseTest extends TestCase
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

    public function testAuthenticatedUserCanPurchaseItem()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = User::factory()->create();
        $csrfToken = csrf_token();

        $user->profile()->create([
        'address' => '東京都渋谷区',
        'post_code' => '123-4567',
        'building' => '渋谷タワー10F',
        'img_url' => '/storage/images/user-profile.jpg',
        ]);
        $item = Item::factory()->create();
         $response = $this->actingAs($user)->post(route('stripe.checkout', [
            'item_id' => $item->id,
            '_token' => csrf_token(),
            'payment_method' => 'card',
         ]));

         $response->assertRedirect();
         $this->assertStringContainsString('https://checkout.stripe.com', $response->headers->get('Location'));

         $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
         ]);
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
}
