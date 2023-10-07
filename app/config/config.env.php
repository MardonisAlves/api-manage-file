<?php
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new UnexpectedValueException('O arquivo de ambiente não foi encontrado.');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

$envPath = __DIR__ . '/env/.env';
loadEnv($envPath);
