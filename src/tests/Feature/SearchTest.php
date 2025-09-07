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
        $keyword = 'A';

        $response = $this->get(route('item.search',['keyword' => $keyword]));

        $response->assertRedirect(route('list', ['tab' => 'recommend', 'search' => $keyword]));

        $response = $this->get(route('list', ['tab' => 'recommend', 'search' => $keyword]));

        $response->assertStatus(200);

        $response->assertSee('テスト商品A');
        $response->assertSee($itemA->img_url);
        
        $response->assertDontSee('テスト商品B');
        $response->assertDontSee('テスト商品C');
        $response->assertDontSee($itemB->img_url);
        $response->assertDontSee($itemC->img_url);
    }


    public function testSearchQueryShouldPersistOnTheMylistPageWithoutOwnItems()
    {
    
        $user = User::factory()->create();

        $bag1 = Item::factory()->create([
            'name' => 'ハンドバッグ',
            'img_url' =>'/storage/images/handbag.jpg',
            ]);
        $bag2 = Item::factory()->create([
            'name' => 'ショルダーバッグ',
            'img_url' => '/storage/images/sholder.jpg',
            ]);
        $kettle = Item::factory()->create([
            'name' => 'やかん',
            'img_url' => '/storage/images/kettle.jpg',
            ]);
        $user->likedItems()->attach([$bag1->id, $kettle->id]);

        $keyword = 'バッグ';
        $response = $this->actingAs($user)->get(route('list', [
        'tab' => 'recommend',
        'search' => $keyword
        ]));
   
        $response->assertSee('ハンドバッグ');
        $response->assertSee($bag1->img_url);

        $response->assertSee('ショルダーバッグ');
        $response->assertSee($bag2->img_url);

        $response->assertDontSee('やかん');
        $response->assertDontSee($kettle->img_url);

        $response = $this->get(route('list', [
            'tab' => 'mylist',
            'search' => $keyword
        ]));
        $response->assertStatus(200);

        $response->assertSee('ハンドバッグ');
        $response->assertSee($bag1->img_url);

        $response->assertDontSee('ショルダーバッグ');
        $response->assertDontSee($bag2->img_url);
     
        $response->assertDontSee('やかん');
        $response->assertDontSee($kettle->img_url);
    }
}


   
