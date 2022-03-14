<?php

use App\Controllers\IndexController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once "../vendor/autoload.php";

const CONTROLLERS = [
    IndexController::class,
];

#[Attribute]
class Route {

    public function __construct(public string $route) {}

}

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader, [
    "cache" => "../var/cache",
]);

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

if (isset($routes[$_SERVER["REQUEST_URI"]])) {
    echo $routes[$_SERVER["REQUEST_URI"]]($twig);
} else {
    echo "Page not found `{$_SERVER["REQUEST_URI"]}`";
}
