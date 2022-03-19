<?php

use App\Controllers\IndexController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Dotenv\Dotenv;

require_once "../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . "/../.env");

const CONTROLLERS = [
    IndexController::class,
];

#[Attribute]
class Route {

    public function __construct(public string $route) {}

}

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

$routes = [];

foreach (CONTROLLERS as $controller) {
    $reflection = new ReflectionClass($controller);

    foreach ($reflection->getMethods() as $method) {
        $attribute = $method->getAttributes(Route::class);
        if (count($attribute) != 1) {
            continue;
        }

        $attribute = $attribute[0];

        $routes[$attribute->getArguments()[0]] = $method->getClosure();
    }

}

$route = explode("?", $_SERVER["REQUEST_URI"])[0];
if (isset($routes[$route])) {
    echo $routes[$route]($twig);
} else {
    echo "Page not found `{$_SERVER["REQUEST_URI"]}`";
}
