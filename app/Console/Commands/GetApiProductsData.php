<?php

namespace App\Console\Commands;

use App\Models\ImportedProductsFile;
use App\Services\CreateNewProductsByFile;
use App\Services\GetNewProductsFilesService;
use Illuminate\Console\Command;

class GetApiProductsData extends Command
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
    protected $description =
    'This command verify the index of products-files and create a determined quantity of products for each file not imported yet.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        GetNewProductsFilesService $getNewProductsFilesService,
        CreateNewProductsByFile $createNewProductsByFile
    ) {

        $newProductsFiles = $getNewProductsFilesService->handle();

        $this->output->progressStart($newProductsFiles->count());

        foreach ($newProductsFiles as $newProductsFile) {

            $createNewProductsByFile->handle($newProductsFile);

            ImportedProductsFile::create(['name' => $newProductsFile]);

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }
}
