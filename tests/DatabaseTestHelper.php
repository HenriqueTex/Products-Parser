<?php

namespace Tests;

use App\Models\ImportedProductFile;
use App\Models\Product;

class DatabaseTestHelper
{
    public static function resetDatabase()
    {
        Product::query()->delete();
        ImportedProductFile::query()->delete();
    }
}
