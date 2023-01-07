<?php

namespace Differ;

use function Differ\parser;
use function Differ\generateAst;
use function Differ\Formatters\stylish;
use function Differ\Formatters\plain;

function gendiff($firstFilepath, $secondFilepath, $format = 'stylish')
{
    $firstFileContent = parser($firstFilepath);
    $secondFileContent = parser($secondFilepath);
    $gendiff = generateAst($firstFileContent, $secondFileContent);
    if ($format === 'stylish') {
        return stylish($gendiff);
    }

    if ($format === 'plain') {
        return plain($gendiff);
    }

    if ($format === 'json') {
        return json_encode($gendiff, JSON_PRETTY_PRINT);
    }
}
