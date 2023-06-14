<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.apiToken')->group(function () {
    Route::get('/', function () {
        try {
            DB::connection()->getMongoClient()->listDatabases();
            $dbConnection = true;
        } catch (Exception) {
            $dbConnection = false;
        }

        // Horário da última vez que o CRON foi executado
        $lastCronExecution = exec('stat -c %Y /path/to/cron_file');

        // Tempo online
        $uptime = exec('uptime -p');

        // Uso de memória
        $memoryUsage = memory_get_usage();

        return response()->json([
            'db_connection' => $dbConnection,
            'last_cron_execution' => $lastCronExecution,
            'uptime' => $uptime,
            'memory_usage' => $memoryUsage,
        ]);
    });

    Route::put('/products/{code}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/{code}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/products/{code}/delete', [ProductController::class, 'delete'])->name('product.delete');
});
Route::get('/apiToken', ApiTokenController::class)->name('apiToken');
