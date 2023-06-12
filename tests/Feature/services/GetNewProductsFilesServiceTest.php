<?php

namespace Tests\Unit\Services;

use App\Models\ImportedProductFile;
use App\Services\GetNewProductsFilesService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetNewProductsFilesServiceTest extends TestCase
{

    public function testHandleReturnsFilteredItems()
    {
        Http::fake([
            '*/index.txt' => Http::response("products_01.json.gz\nproducts_02.json.gz\nproducts_03.json.gz\n"),
        ]);

        ImportedProductFile::create(['name' => 'products_01.json.gz']);
        ImportedProductFile::create(['name' => 'products_04.json.gz']);

        $service = new GetNewProductsFilesService();

        $result = $service->handle();

        $this->assertCount(2, $result);

        $this->assertTrue($result->contains('products_02.json.gz'));
        $this->assertTrue($result->contains('products_03.json.gz'));

        $this->assertNotTrue($result->contains('products_01.json.gz'));
        $this->assertNotTrue($result->contains('products_04.json.gz'));
    }
}
