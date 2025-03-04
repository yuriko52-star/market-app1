<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
   /* public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    */
    public function testUserCanUpdatePaymentMethod()
    {
        $user = User::factory()->create();
        $user->profile()->create([
        'address' => '東京都渋谷区',
        'post_code' => '123-4567',
        'building' => '渋谷タワー10F',
        'img_url' => '/storage/images/user-profile.jpg',
        ]);


        $item = Item::factory()->create();

        $purchase =  Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($user)->post(route('purchase.updatePayment'), [
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);

        $response->assertRedirect(route('purchase.show', ['item_id' => $item->id]));

        $this->assertDatabaseHas('purchases',[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);
    }

    public function testPaymentMethodIsUpdatedAndReflectedInView()
    {
        $user = User::factory()->create();
        $user->profile()->create([
        'address' => '東京都渋谷区',
        'post_code' => '123-4567',
        'building' => '渋谷タワー10F',
        'img_url' => '/storage/images/user-profile.jpg',
        ]);
        $item = Item::factory()->create();
        $purchase = Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card', 
        ]);

        $this->actingAs($user)->post(route('purchase.updatePayment'),[
            'item_id' => $item->id,
            'payment_method' => 'konbini',
        ]);
        $purchase->refresh();

         $response = $this->actingAs($user)->get(route('purchase.show', ['item_id' => $item->id]));

        $response->assertSee('コンビニ支払い');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'konbini',
        ]);
    }


}
