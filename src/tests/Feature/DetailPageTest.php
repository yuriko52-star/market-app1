<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Condition;

class DetailPageTest extends TestCase
{
    use RefreshDatabase;

    public function testDetailPageDisplayCorrectInformation()
    {
        $user = User::factory()->create();

        $user_id = $user->id;
        $profile = Profile::factory()->create([
            'user_id' => $user_id,
            'img_url' => '/storage/images/user-profile.jpg',
        ]);
        $categories = Category::factory()->count(3)->create();
        $condition = Condition::factory()->create();
        //  $condition_id = $condition->id;
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'img_url' => '/storage/images/test-product.jpg',
            'price' => 5000,
            'description' => 'これはテスト商品の説明です',
            'condition_id' => $condition->id,
           
        ]);
        $item->categories()->attach($categories->pluck('id'));
        Like::factory()->count(3)->create([
            'item_id' => $item->id,
            // 'user_id' => $user->id,
        ]);
        $comments = Comment::factory()->count(2)->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => 'ほしいわあ',
        ]);
        
        $response = $this->actingAs($user)->get(route('item.show', ['item' => $item->id]));

         $response->assertSee($item->name);
        $response->assertSee($item->brand_name);
        $response->assertSee($item->img_url);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->description);
        $response->assertSee($condition->content);
        // $response->assertSee($category->name);

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }

        $response->assertSee('3');

        $response->assertSee('2');

        foreach($comments as $comment) {
            $response->assertSee($comment->comment);
            $response->assertSee($comment->user->name);
            $response->assertSee($comment->user->profile->img_url);

        }

        
    }
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
}
