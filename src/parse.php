<?php

const SANDBOX_DIRECTORY = "../sandbox/";
const ONE_MINUTE = 60;
const PHP_HEADER = "<?php\n\n";

function main() {
    removePreviousFiles(SANDBOX_DIRECTORY);
    createSandboxDirectory();

    echo createScript($_POST["code"]);
}

function createSandboxDirectory() {
    if (!is_dir(SANDBOX_DIRECTORY)) {
        mkdir(SANDBOX_DIRECTORY);
    }
}

function removePreviousFiles(string $fileOrDirectory) {
    $now = time();

    if (!file_exists($fileOrDirectory)) {
        return;
    }

    if (!is_dir($fileOrDirectory)) {
        if($now - filemtime($fileOrDirectory) >= ONE_MINUTE) {
            unlink($fileOrDirectory);
        }
    } else {
        $directoryContent = scandir($fileOrDirectory);
        $items = array_diff($directoryContent, [".", ".."]);
        foreach ($items as $item) {
            removePreviousFiles($fileOrDirectory . DIRECTORY_SEPARATOR . $item);
        }

        @rmdir($fileOrDirectory);
    }
}

function createScript(string $content): string {
    $file = SANDBOX_DIRECTORY . "script-" . round(microtime(true) * 1000) . ".php";

    file_put_contents($file, PHP_HEADER . trim($content));

    return $file;
}

main();