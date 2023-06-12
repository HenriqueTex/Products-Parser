<?php

namespace App\Console\Commands;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Services\GetIndexProductsFilesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class getApiProductsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-api-products-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(GetIndexProductsFilesService $getIndexProductsFilesService)
    {
        $getIndexProductsFilesService->handle();

        $this->output->progressStart(100);
        Product::query()->delete();
        // $getIndexProductsFilesService->handle();

        $url = 'https://challenges.coode.sh/food/data/json/products_01.json.gz';
        $filePath = storage_path('app/products_01.json.gz');
        // $client = new Client();
        Http::sink($filePath)->get($url);
        // $client->get($url, ['sink' => $filePath]);

        $compressedFilePath = storage_path('app/products_01.json.gz');
        $uncompressedFilePath = storage_path('app/products_01.json');

        // Descompactar o arquivo .gz
        $compressedFile = gzopen($compressedFilePath, 'rb');
        $uncompressedFile = fopen($uncompressedFilePath, 'w');

        while (!gzeof($compressedFile)) {
            $uncompressedData = gzread($compressedFile, 4096);
            fwrite($uncompressedFile, $uncompressedData);
        }

        gzclose($compressedFile);
        fclose($uncompressedFile);
        // Ler o conteúdo do arquivo descompactado
        $file = file(Storage::path('products_01.json'));

        for ($i = 0; $i < 100; $i++) {
            $data = json_decode($file[$i], true);
            $data['imported_t'] = now()->toISOString();
            $data['status'] = ProductStatus::Published;
            Product::create($data);
            $this->output->progressAdvance();
        }

        // Realizar qualquer operação adicional necessária com os itens

        // Excluir o arquivo descompactado, se necessário
        Storage::delete('products_01.json');
        $this->output->progressFinish();
    }
}
