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
        $filePath = $this->downloadFile($fileName);

        $this->createProducts($filePath);

        $this->deleteFiles();
    }

    protected function deleteFiles()
    {
        Storage::delete('products.json');
        Storage::delete('products.json.gz');
    }

    protected function createProducts(string $filePath)
    {
        $file = file($filePath);

        $productsCountPerFile = config('open-food.product_quantity_by_file');

        for ($i = 0; $i < $productsCountPerFile; $i++) {
            $data = json_decode($file[$i], true);
            $data['imported_t'] = now()->toISOString();
            $data['status'] = ProductStatus::Published;
            Product::create($data);
        }
    }

    protected function downloadFile(string $fileName): string
    {
        $compressedFilePath = Storage::path('products.json.gz');
        Http::sink($compressedFilePath)->get(config('open-food.open_food_url_prefix') . $fileName);

        $uncompressedFilePath = Storage::path('products.json');

        $compressedFile = gzopen($compressedFilePath, 'rb');
        $uncompressedFile = fopen($uncompressedFilePath, 'w');

        while (!gzeof($compressedFile)) {
            $uncompressedData = gzread($compressedFile, 4096);
            fwrite($uncompressedFile, $uncompressedData);
        }

        gzclose($compressedFile);
        fclose($uncompressedFile);

        return $uncompressedFilePath;
    }
}
