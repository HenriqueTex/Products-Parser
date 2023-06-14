<?php


namespace App\Services;

use App\Models\ImportedProductsFile;
use Illuminate\Support\Facades\Http;

class GetNewProductsFilesService
{
	public function handle()
	{
		$openFoodUrlIndex = config('open-food.open_food_url_prefix') . "index.txt";
		$response = Http::get($openFoodUrlIndex);

		$body = $response->getBody()->getContents();

		$items = collect(explode("\n", $body))->filter();

		$ImportedProductsFiles = ImportedProductsFile::pluck('name');
		return $items->filter(fn ($item) => $ImportedProductsFiles->doesntContain($item));
	}
}
