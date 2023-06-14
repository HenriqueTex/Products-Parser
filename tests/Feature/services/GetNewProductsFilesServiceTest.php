<?php

namespace Tests\Feature\Services;

use App\Models\ImportedProductsFile;
use Illuminate\Support\Facades\Http;
use App\Services\GetNewProductsFilesService;
use Tests\TestCase;

class GetNewProductsFilesServiceTest extends TestCase
{

	public function test_can_be_able_to_handle_returns_filtered_items()
	{
		Http::fake([
			'*/index.txt' => Http::response("products_01.json.gz\nproducts_02.json.gz\nproducts_03.json.gz\n"),
		]);

		ImportedProductsFile::create(['name' => 'products_01.json.gz']);
		ImportedProductsFile::create(['name' => 'products_04.json.gz']);

		$service = new GetNewProductsFilesService();

		$result = $service->handle();

		$this->assertCount(2, $result);

		$this->assertTrue($result->contains('products_02.json.gz'));
		$this->assertTrue($result->contains('products_03.json.gz'));

		$this->assertNotTrue($result->contains('products_01.json.gz'));
		$this->assertNotTrue($result->contains('products_04.json.gz'));
	}
}
