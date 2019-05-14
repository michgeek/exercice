<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * There is a lot more missing in this feature testing.
 * Authentication and authorization are one of them:
 *
 * User is authenticated but not authorized
 * User is authenticated and authorized
 *
 * As the software grow, more scenario MUST be added in here:
 * User is authorized to create "free" products (price is 0)
 * User is not authorized to create "free" products
 * Unauthenticated users are allowed to create "free" products
 * Not allowing storing a duplicate product
 * Delete product
 * Update a product
 *
 * Then malicious input as well:
 *
 * Not allowing a 10k chars description
 * Not allowing a 10k chars name
 * Not allowing special chars in name or description
 * Negative price... e.g. people would then steal your money...
 * Price is not numeric
 * Price has weird chars... e.g. someone decided to add the currency symbol
 *
 * etc.
 */
class StoringProductTest extends TestCase {

    /**
     * @testdox It should insert a product
     * @test
     */
    public function it_should_insert_a_product()
    {
        $product = [
            'name'        => 'My Product',
            'description' => 'This is a test product',
            'price'       => 13.37
        ];

        $response = $this->json('post', '/storeProduct', $product);
        $response->assertStatus(Response::HTTP_CREATED);

        $inserted = $response->getOriginalContent();
        $this->assertEquals('My Product', $inserted->name);
        $this->assertEquals('This is a test product', $inserted->description);
        $this->assertEquals(13.37, $inserted->price);
    }

    /**
     * @testdox It should store the product when missing product description because it is optional
     * @test
     */
    public function it_should_not_store_the_product_when_missing_product_description_because_it_is_optional()
    {
        $product = [
            'name'        => 'My product',
            'description' => null,
            'price'       => '13.37'
        ];

        $response = $this->json('post', '/storeProduct', $product);
        $response->assertStatus(Response::HTTP_CREATED);

        $inserted = $response->getOriginalContent();
        $this->assertEquals('My product', $inserted->name);
        $this->assertEmpty($inserted->description);
        $this->assertEquals('13.37', $inserted->price);
    }

    /**
     * @testdox It should not insert a product when the price is negative
     * @test
     */
    public function it_should_not_insert_a_product_when_the_price_is_negative()
    {
        $product = [
            'name'        => 'My Product',
            'description' => 'This is a test product',
            'price'       => -13.37
        ];

        $response = $this->json('post', '/storeProduct', $product);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['price']);
        $response->assertJsonMissing(['name', 'description']);
    }

    /**
     * @testdox It should not store the product when missing product name
     * @test
     */
    public function it_should_not_store_the_product_when_missing_product_name()
    {
        $product = [
            'name'        => null,
            'description' => 'This is a test product',
            'price'       => '13.37'
        ];

        $response = $this->json('post', '/storeProduct', $product);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonMissing(['price', 'description']);
    }
}
