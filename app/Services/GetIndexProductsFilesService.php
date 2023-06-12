<?php


namespace App\Services;

use App\Models\ImportedProductFile;
use Illuminate\Support\Facades\Http;

class GetIndexProductsFilesService
{
    public function handle()
    {
        $url = 'https://challenges.coode.sh/food/data/json/index.txt';
        $response = Http::get($url);
        $body = $response->getBody()->getContents();

        $items = collect(explode("\n", $body))->filter(); // Separa a string em itens usando a quebra de linha como delimitador


        $importedProductFiles = ImportedProductFile::pluck('name');
        return $items->filter(fn ($item) => $importedProductFiles->doesntContain($item));
    }
}
