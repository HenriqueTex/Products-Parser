<?php

namespace Tests\Feature\Services;

use App\Models\Product;
use App\Services\CreateNewProductsByFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateNewProductsByFileTest extends TestCase
{

    public function test_can_be_able_to_create_products_on_file()
    {
        $file = file(base_path('tests/files/products_test.json.gz'));

        Http::fake([
            '*' => Http::response(file_get_contents(base_path('tests/files/products_test.json.gz'))),
        ]);

        $createNewProductsByFile = new CreateNewProductsByFile();

        $createNewProductsByFile->handle('products.json.gz');

        $firstProduct = json_decode($file[0], true);

        $secondProduct = json_decode($file[1], true);

        $this->assertDatabaseHas('products', ['code' => $firstProduct['code'], 'product_name' => $firstProduct['product_name']]);
        $this->assertDatabaseHas('products', ['code' => $secondProduct['code'], 'product_name' => $secondProduct['product_name']]);
        $this->assertDatabaseCount('products', count($file));
    }

    public function shouldBeAbleToCreateProductsOnFileWithMoreThanHundred()
    {

        Http::fake([
            '*' => Http::response(file_get_contents(base_path('tests/files/products_test_with_more_than_hundred_products.json.gz'))),
        ]);

        $createNewProductsByFile = new CreateNewProductsByFile();

        $createNewProductsByFile->handle('products.json.gz');

        $this->assertDatabaseCount('products', 100);
    }
}
