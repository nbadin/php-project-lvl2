<?php

namespace Differ\Differ;

use function Differ\Parser\parser;
use function Differ\getAst;
use function Differ\Formatters\Sylish\stylish;
use function Differ\Formatters\Plain\plain;

function gendiff(string $firstFilepath, string $secondFilepath, string $format = 'stylish'): string
{
    $firstFileContent = parser($firstFilepath);
    $secondFileContent = parser($secondFilepath);
    $gendiff = getAst($firstFileContent, $secondFileContent);
    if ($format === 'stylish') {
        return stylish($gendiff);
    }

    if ($format === 'plain') {
        return plain($gendiff);
    }

    if ($format === 'json') {
        return json_encode($gendiff, JSON_PRETTY_PRINT);
    }
    return '';
}
