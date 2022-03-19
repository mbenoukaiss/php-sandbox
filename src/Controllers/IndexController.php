<?php

namespace App\Controllers;

use App\Utils\ScriptUtils;
use App\Utils\ErrorUtils;
use Route;
use Twig\Environment;

class IndexController {

    #[Route("/")]
    public static function index(Environment $twig): string {
        return $twig->load("index.html.twig")->render([
            "php_version" => phpversion(),
            "reported_errors" => ErrorUtils::getReportedErrors(),
            "loaded_extensions" => get_loaded_extensions(),
        ]);
    }

    #[Route("/create-script")]
    public static function createScript(): string {
        ScriptUtils::removePreviousFiles();
        ScriptUtils::createSandboxDirectory();

        return ScriptUtils::createScript($_POST["code"]);
    }

    #[Route("/run")]
    public static function run(): string {
        $start = microtime(true);
        $output = file_get_contents("http://{$_SERVER["HTTP_HOST"]}/build/sandbox/{$_GET["script"]}/script.php");
        $executionTime = (microtime(true) - $start);

        if($executionTime < 1000) {
            $executionTime *= 1000;
            $unit = "ms";
        } else {
            $unit = "s";
        }

        return json_encode([
            "output" => $output,
            "executionTime" => round($executionTime, 2) . $unit,
        ]);
    }

    #[Route("/command")]
    public static function command(): ?string {
        $command = $_GET["command"];
        if(!empty($_ENV["CUSTOM_PATH"])) {
            $command = "set \"PATH=%PATH%;" . $_ENV["CUSTOM_PATH"] . "\" && $command";
        }

        $result = shell_exec("cd " . ScriptUtils::SANDBOX_DIRECTORY . "{$_GET["script"]} && $command 2>&1");

        return str_replace("\n", "\n", $result);
    }

}
