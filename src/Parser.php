<?php

namespace Differ\Parser;

use Exception;
use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

function parser(string $filePath): array
{
    $partsOfPath = explode('.', $filePath);
    $ext = end($partsOfPath);
    $fileContent = file_get_contents($filePath);

    if ($fileContent === false) {
        throw new Exception('Unable to read the file');
    }

    if ($ext === 'json') {
        return json_decode($fileContent, true);
    } elseif ($ext === 'yaml' || $ext === 'yml') {
        return Yaml::parse($fileContent, Yaml::DUMP_OBJECT_AS_MAP);
    } else {
        throw new InvalidArgumentException('Unsupported format of file');
    }
}
