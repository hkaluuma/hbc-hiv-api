<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$requesturi = $_SERVER["REQUEST_URI"];
$parts = explode("/", $requesturi);
//print_r($parts);

if ($parts[1] != "products") {
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;
//var_dump($id);
$database =  new Database("localhost", "product_db", "root", "root");

//$database->getConnection();

$gateway = new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->processRequest ($_SERVER["REQUEST_METHOD"], $id);
