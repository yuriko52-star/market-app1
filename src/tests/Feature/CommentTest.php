<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;


class CommentTest extends TestCase
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
    public function testAuthenticatedUserCanPostComment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comment.store',['item_id' => $item->id ]), [
           'comment' => 'テストコメント', 
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }
    public function testCommentCountIncreasesAfterPost()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $initialCount = $item->comments()->count();
        $this->actingAs($user)->post(route('comment.store', ['item_id' => $item->id]), [
        'comment' => 'This is a test comment.',
        ]);

        $item->refresh();

        $this->assertEquals($initialCount + 1, $item->comments()->count());

    }

    public function testGuestCanNotPostComment()
    {
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        $item = Item::factory()->create();
        $response = $this->post(route('comment.store', ['item_id' => $item->id]), [
            'comment' => 'テストコメント',
        ]);

        $this->assertDatabaseMissing('comments', ['comment' => 'テストコメント']);
    }

    public function testCommentIsRequired()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comment.store', ['item_id' => $item->id]), [
        'comment' => '',
       ]); 
    
    }

    public function testCommentMustNotExceed255Characters()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $user = User::factory()->create();
        $item = Item::factory()->create();
        $longComment = str_repeat('a',256);

         $response = $this->actingAs($user)->post(route('comment.store', ['item_id' => $item->id]), [
        'comment' => $longComment,
        ]);
    }
}
