<?php

namespace Tests;

use App\Models\ApiToken;
use App\Models\ImportedProductsFile;
use App\Models\Product;

class DatabaseTestHelper
{
	public static function resetDatabase()
	{
		Product::query()->delete();
		ImportedProductsFile::query()->delete();
		ApiToken::query()->delete();
	}
}
