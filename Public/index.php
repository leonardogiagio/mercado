<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

require_once '../vendor/autoload.php';

use App\Services;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_GET['url']) {
    $url = explode('/', $_GET['url']);

    if ($url[0] === 'api') {
        array_shift($url);

        $modelName = ucfirst($url[0]);
        $serviceName = $modelName . 'Service';
        array_shift($url);

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        try {
            $namespaceModel = "App\\Models\\{$modelName}";
            $model = new $namespaceModel();

            $namespaceService = "App\\Services\\{$serviceName}";
            $service = new $namespaceService($model);

            $response = call_user_func_array([$service, $method], $url);
        
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $response]);
            exit;
        } catch (\Exception $e) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'data' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}
