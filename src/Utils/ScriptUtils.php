<?php

namespace App\Utils;

class ScriptUtils {

    const SANDBOX_DIRECTORY = "../build/sandbox/";
    const ONE_MINUTE = 60;
    const PHP_HEADER = "<?php\n\n";

    public static function createSandboxDirectory() {
        if (!is_dir(self::SANDBOX_DIRECTORY)) {
            mkdir(self::SANDBOX_DIRECTORY);
        }
    }

    public static function removePreviousFiles(string $fileOrDirectory = self::SANDBOX_DIRECTORY) {
        $now = time();

        if (!file_exists($fileOrDirectory)) {
            return;
        }

        if (!is_dir($fileOrDirectory)) {
            if($now - filemtime($fileOrDirectory) >= self::ONE_MINUTE) {
                unlink($fileOrDirectory);
            }
        } else {
            $directoryContent = scandir($fileOrDirectory);
            $items = array_diff($directoryContent, [".", ".."]);
            foreach ($items as $item) {
                self::removePreviousFiles($fileOrDirectory . DIRECTORY_SEPARATOR . $item);
            }

            @rmdir($fileOrDirectory);
        }
    }

    public static function createScript(string $content): string {
        $directory = "script-" . round(microtime(true) * 1000);
        mkdir(self::SANDBOX_DIRECTORY . $directory);

        $file = self::SANDBOX_DIRECTORY . "$directory/script.php";
        file_put_contents($file, self::PHP_HEADER . trim($content));

        return ltrim($directory, "./");
    }

}