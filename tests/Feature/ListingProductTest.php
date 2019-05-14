<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;

class ListingProductTest extends TestCase {

    /**
     * @testdox It should list all the products
     * @test
     */
    public function it_should_list_all_the_products()
    {
        Product::create(['name' => 'Product 1', 'price' => '1']);
        Product::create(['name' => 'Product 2', 'price' => '2']);
        Product::create(['name' => 'Product 3', 'price' => '3']);

        $response = $this->json('get', '/listProducts');
        $response->assertOk();

        $list = $response->getOriginalContent();
        $this->assertCount(3, $list);
        $this->assertEquals(['Product 1', 'Product 2', 'Product 3'], $list->pluck('name')->all());
    }
}
