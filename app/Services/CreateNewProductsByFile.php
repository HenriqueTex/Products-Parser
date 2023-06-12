<?php


namespace App\Services;

use App\Enums\ProductStatus;
use App\Models\ImportedProductFile;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CreateNewProductsByFile
{
    public function handle(string $fileName)
    {

        $this->downloadFile($fileName);
        $this->createProducts();
        $this->deleteFile();
    }
    protected function deleteFile()
    {
        Storage::delete('products.json');
    }
    protected function createProducts()
    {
        $file = file(Storage::path('products.json'));

        for ($i = 0; $i < config('open-food.product_quantity_by_file'); $i++) {
            $data = json_decode($file[$i], true);
            $data['imported_t'] = now()->toISOString();
            $data['status'] = ProductStatus::Published;
            Product::create($data);
        }
    }
    protected function downloadFile(string $fileName)
    {
        $filePath = storage_path('app/products.json.gz');
        Http::sink($filePath)->get(config('open-food.open_food_url_prefix') . $fileName);

        $compressedFilePath = storage_path('app/products.json.gz');
        $uncompressedFilePath = storage_path('app/products.json');

        $compressedFile = gzopen($compressedFilePath, 'rb');
        $uncompressedFile = fopen($uncompressedFilePath, 'w');

        while (!gzeof($compressedFile)) {
            $uncompressedData = gzread($compressedFile, 4096);
            fwrite($uncompressedFile, $uncompressedData);
        }

        gzclose($compressedFile);
        fclose($uncompressedFile);
    }
}
