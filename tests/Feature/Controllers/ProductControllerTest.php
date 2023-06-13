<?php

namespace Tests\Feature\Controllers;

use App\Models\Product;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function test_can_list_all_products()
    {
        $productQuantity = 5;

        Product::factory()->count($productQuantity)->create();

        $response = $this->get('/api/products');

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

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $this->assertEquals(count(json_decode($response->getContent())->data), $productsPerPage);
    }

    public function test_can_show_product_by_code()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', $product->code));

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

        $response = $this->get(route('product.show', $wrongCode));

        $response->assertStatus(404);
    }
}
