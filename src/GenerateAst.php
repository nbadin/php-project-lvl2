<?php

namespace Gendiff;

function generateAst($firstFile, $secondFile)
{
    $allKeys = array_unique([...array_keys($firstFile), ...array_keys($secondFile)]);
    asort($allKeys); // МУТИРУЕТ МАССИВ
    return array_map(function ($key) use ($firstFile, $secondFile) {
        if (!array_key_exists($key, $firstFile)) {
            $value = is_array($secondFile[$key])
                ? generateAst($secondFile[$key], $secondFile[$key])
                : $secondFile[$key];
            return ['key' => $key, 'status' => 'added', 'value' => $value];
        }

        if (!array_key_exists($key, $secondFile)) {
            $value = is_array($firstFile[$key]) ? generateAst($firstFile[$key], $firstFile[$key]) : $firstFile[$key];
            return [
                'key' => $key,
                'status' => 'deleted',
                'value' => $value
            ];
        }

        if (is_array($firstFile[$key]) && is_array($secondFile[$key])) {
            return [
                'key' => $key,
                'status' => 'hasChildren',
                'value' => generateAst($firstFile[$key], $secondFile[$key])
            ];
        }

        if ($firstFile[$key] !== $secondFile[$key]) {
            $oldValue = is_array($firstFile[$key]) ? generateAst($firstFile[$key], $firstFile[$key]) : $firstFile[$key];
            $newValue = is_array($secondFile[$key]) ? generateAst($secondFile[$key], $secondFile[$key]) : $secondFile[$key];
            return [
                'key' => $key,
                'status' => 'changed',
                'oldValue' => $oldValue,
                'newValue' => $newValue
            ];
        }
        return ['key' => $key, 'status' => 'equal', 'value' => $firstFile[$key]];
    }, $allKeys);
}