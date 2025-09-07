<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Storage;

class ExhibitionTest extends TestCase
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
    public function testAuthenticatedUserCanExhibitItem()
    {
       

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();
        $file = UploadedFile::fake()->create('test.jpg',100, 'image/jpeg');
        $postData = [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => '5000',
            'description' => 'これはテスト商品の説明です。',
            'condition_id' => $condition->id,
            'img_url' => $file,
            'category_ids' => [$category->id],
        ];
         $response = $this->actingAs($user)->post(route('sell.store'), $postData);
         $response->assertRedirect(route('mypage', ['tab' => 'sell']));

         $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 5000,
            'description' => 'これはテスト商品の説明です。',
            'condition_id' => $condition->id,
         ]);

         $item = Item::where('user_id', $user->id)->firstOrFail();
         Storage::disk('public')->assertExists('/images/' . basename($item->img_url));

         $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
         ]);
    }


}
