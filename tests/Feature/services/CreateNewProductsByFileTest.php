<?php

namespace Tests\Feature\Services;

use App\Models\Product;
use App\Services\CreateNewProductsByFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateNewProductsByFileTest extends TestCase
{

    public function shouldBeAbleToCreateProductsOnFile()
    {
        Http::fake([
            '*' => Http::response(Storage::get('products.json.gz')),
        ]);
        $createNewProductsByFile = new CreateNewProductsByFile();
        $createNewProductsByFile->handle('products.json.gz');
        
        //veerificar productIndex
        //verifcar produtos
        //verificar arquivos
    }
    public function shouldBeAbleToCreateProductsOnFileWithLessThanHundred()
    {
        Http::fake([
            '*' => Http::response(Storage::get('products.json.gz')),
        ]);
        $createNewProductsByFile = new CreateNewProductsByFile();
        $createNewProductsByFile->handle('products.json.gz');
    }
}
