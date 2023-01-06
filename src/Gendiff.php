<?php

namespace Gendiff;

use function Gendiff\parser;
use function Gendiff\generateAst;
use function Gendiff\Formatters\stylish;
use function Gendiff\Formatters\plain;

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
}
