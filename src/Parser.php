<?php

namespace Differ;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

function parser($filePath)
{
    $partsOfPath = explode('.', $filePath);
    $ext = end($partsOfPath);
    $fileContent = file_get_contents($filePath);
    if ($ext === 'json') {
        return json_decode($fileContent, true);
    } elseif ($ext === 'yaml' || $ext === 'yml') {
        return Yaml::parse($fileContent, Yaml::DUMP_OBJECT_AS_MAP);
    } else {
        throw new InvalidArgumentException('Unsupported format of file');
    }
}
