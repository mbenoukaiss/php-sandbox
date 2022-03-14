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

    #[Route("/parse")]
    public static function parse(): string {
        ScriptUtils::removePreviousFiles();
        ScriptUtils::createSandboxDirectory();

        return ScriptUtils::createScript($_POST["code"]);
    }

}
