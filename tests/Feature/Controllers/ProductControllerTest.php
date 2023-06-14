<?php

namespace Tests\Feature\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{


    public function test_can_list_all_products()
    {

        $productQuantity = 5;

        Product::factory()->count($productQuantity)->create();

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->get(route('product.index'), ['Authorization' => $apiToken->getContent()]);

        $response->assertStatus(200);


        $this->assertEquals(count(json_decode($response->getContent())->data), $productQuantity);

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'code',
                    'status',
                    'imported_t',
                    'url',
                    'creator',
                    'created_t',
                    'last_modified_t',
                    'product_name',
                    'quantity',
                    'brands',
                    'categories',
                    'labels',
                    'cities',
                    'purchase_places',
                    'stores',
                    'ingredients_text',
                    'traces',
                    'serving_size',
                    'serving_quantity',
                    'nutriscore_score',
                    'nutriscore_grade',
                    'main_category',
                    'image_url',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
    }
    public function test_can_list_products_with_limit_pagination()
    {
        $productQuantity = 40;
        $productsPerPage = 30;

        Product::factory()->count($productQuantity)->create();

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->get(route('product.index'), ['Authorization' => $apiToken->getContent()]);

        $response->assertStatus(200);

        $this->assertEquals(count(json_decode($response->getContent())->data), $productsPerPage);
    }

    public function test_can_show_product_by_code()
    {
        $product = Product::factory()->create();

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->get(route('product.show', $product->code), ['Authorization' => $apiToken->getContent()]);

        $response->assertStatus(200);

        $arrayData = json_decode($response->getContent());

        $this->assertDatabaseHas(
            'products',
            [
                'code' => $arrayData->code,
                'product_name' => $arrayData->product_name,
                'image_url' => $arrayData->image_url
            ]
        );
    }

    public function test_can_not_find_product_with_wrong_code()
    {
        Product::factory()->create(['code' => 1]);

        $wrongCode = 2;

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->get(route('product.show', $wrongCode), ['Authorization' => $apiToken->getContent()]);

        $response->assertStatus(404);
    }

    public function test_can_be_able_to_delete_a_product()
    {
        $product = Product::factory()->create();

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->post(route('product.delete', $product->code), [], ['Authorization' => $apiToken->getContent()]);

        $deletedProduct = Product::find($product->id);

        $response->assertStatus(200);

        $this->assertEquals($deletedProduct->status, ProductStatus::Trash->value);
    }



    public function test_can_not_be_able_to_delete_a_product_with_wrong_code()
    {
        Product::factory()->create(['code' => 1]);

        $wrongCode = 2;

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->post(route('product.delete', $wrongCode), [], ['Authorization' => $apiToken->getContent()]);

        $response->assertStatus(404);
    }

    public function test_can_be_able_to_update_a_product()
    {
        $product = Product::factory()->create();

        $newProduct = Product::factory()->make();

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->withHeaders(['Authorization' => $apiToken->getContent()])
            ->put(
                route(
                    'product.update',
                    $product->code
                ),
                ['product_name' => $newProduct->product_name, 'quantity' => $newProduct->quantity, 'nutriscore_score' => $newProduct->nutriscore_score]
            );

        $updatedProduct = Product::find($product->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [$updatedProduct->product_name, $updatedProduct->quantity, $updatedProduct->nutriscore_score],
            [$newProduct->product_name, $newProduct->quantity, $newProduct->nutriscore_score]
        );
    }

    public function test_can_not_be_able_to_update_a_product_code()
    {
        $product = Product::factory()->create();

        $newCode = Product::factory()->make()->code;

        $apiToken = $this->post(route('apiToken'), ['email' => 'test@test.com']);

        $response = $this->withHeaders(['Authorization' => $apiToken->getContent()])
            ->put(
                route(
                    'product.update',
                    $product->code
                ),
                ['code' => $newCode]
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', ['code' => $product->code]);

        $this->assertDatabaseMissing('products', ['code' => $newCode]);
    }
}
