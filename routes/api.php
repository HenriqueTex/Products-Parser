<?php

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

Route::get('/', function () {
    dd(DB::connection()->getMongoClient()->listDatabases());
    // try {
    //     $manager = new Manager("mongodb://localhost:27017");
    //     $manager->executeCommand('admin', new \MongoDB\Driver\Command(['ping' => 1]));
    //     $dbConnection = true;
    // } catch (\Exception $e) {
    //     $dbConnection = false;
    // }

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
