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

   
}