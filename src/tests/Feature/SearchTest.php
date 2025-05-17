<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class SearchTest extends TestCase
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
    public function testPartialMatchSearchByItemNameShouldWork ()
    {
        $itemA = Item::factory()->create([
            'name' => 'テスト商品A',
            'img_url' =>'/storage/images/testA.jpg',
        ]);
        $itemB = Item::factory()->create([
            'name' => 'テスト商品B',
            'img_url' => '/storage/images/testB.jpg',
        ]);
        $itemC = Item::factory()->create([
            'name' => 'テスト商品C',
            'img_url' => '/storage/images/testC.jpg',
        ]);

        $response = $this->get(route('item.search',['keyword' => 'テスト']));

        $response->assertStatus(200);
        $response->assertSee('テスト商品A');
        $response->assertSee('テスト商品B');
        $response->assertSee('テスト商品C');

        $response->assertSee($itemA->img_url);
        $response->assertSee($itemB->img_url);
        $response->assertSee($itemC->img_url);
        
    }


public function testSearchQueryShouldPersistOnTheMylistPageWithoutOwnItems()
{
    
    $user = User::factory()->create();

    
    $otherUser = User::factory()->create();
   
    $otherItems = collect([
        Item::factory()->create([
        'user_id' => $otherUser->id,
            'name' => 'テスト商品C',
            'img_url' =>'/storage/images/testC.jpg',
        ]),
        Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => 'テスト商品D',
            'img_url' => '/storage/images/testD.jpg',
        ]),
    ]);


    
    $ownItem = Item::factory()->create([
        'user_id' => $user->id,
        'name' => 'テスト商品1',
        'img_url' => '/storage/images/test1.jpg',
    ]);

    
    $response = $this->actingAs($user)->get(route('item.search', ['keyword' => 'テスト']));

    
    foreach ($otherItems as $item) {
        $response->assertSee($item->name);
        $response->assertSee($item->img_url);
    }
    $response = $this->actingAs($user)->get(route('item.search', ['keyword' => 'テスト']));


    $response->assertDontSee($ownItem->name);
    $response->assertDontSee($ownItem->img_url);
    
    $response->assertSee('href="http://localhost?tab=recommend&amp;keyword=%E3%83%86%E3%82%B9%E3%83%88"', false);
    $response->assertSee('href="http://localhost/list/search?tab=mylist&amp;keyword=%E3%83%86%E3%82%B9%E3%83%88"', false);

}
}


   
