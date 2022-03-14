<?php

const SANDBOX_DIRECTORY = "sandbox/";
const ONE_MINUTE = 60;
const PHP_HEADER = "<?php\n\n";

function main() {
    createSandboxDirectory();
    removePreviousFiles();

    echo createScript($_POST["code"]);
}

function createSandboxDirectory() {
    if (!is_dir(SANDBOX_DIRECTORY)) {
        mkdir(SANDBOX_DIRECTORY);
    }
}

function removePreviousFiles() {
    $now = time();

    $directoryContent = scandir(SANDBOX_DIRECTORY);
    $files = array_diff($directoryContent, [".", ".."]);
    foreach ($files as $file) {
        $path = SANDBOX_DIRECTORY . $file;
        if (is_file($path)) {
            if ($now - filemtime($path) >= ONE_MINUTE) {
                unlink($path);
            }
        }
    }
}

function createScript(string $content): string {
    $file = SANDBOX_DIRECTORY . "/script-" . bin2hex(random_bytes(8)) . ".php";

    file_put_contents($file, PHP_HEADER . trim($content));

    return $file;
}

main();