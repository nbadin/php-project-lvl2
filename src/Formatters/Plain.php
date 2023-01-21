<?php

namespace Differ\Formatters\Plain;

use function Functional\retry;

function formatterOfType(array|string|bool|null|int $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }
    
    if ($value === true) {
        return 'true';
    }

    if ($value === false) {
        return 'false';
    }
    
    if ($value === null) {
        return 'null';
    }

    if (gettype($value) === 'string') {
        return "'{$value}'";
    }

    return $value;
}

function getDiffInString(array $ast, array $parents = []): array
{
    $diff = array_filter($ast, fn($item) => $item['status'] !== 'equal');
    return array_map(function ($item) use ($parents) {
        $property = count($parents) === 0 ? $item['key'] : implode('.', [...$parents, $item['key']]);
        if ($item['status'] === 'deleted') {
            return "Property '{$property}' was removed";
        }

        if ($item['status'] === 'added') {
            $value = formatterOfType($item['value']);
            return "Property '{$property}' was added with value: {$value}";
        }

        if ($item['status'] === 'changed') {
            $oldValue = formatterOfType($item['oldValue']);
            $newValue = formatterOfType($item['newValue']);
            return "Property '{$property}' was updated. From {$oldValue} to {$newValue}";
        }

        if ($item['status'] === 'hasChildren') {
            $newParent = [...$parents, $item['key']];
            return implode("\n", [...(getDiffInString($item['value'], $newParent))]);
        }
    }, $diff);
}

function plain($ast): string
{
    return implode("\n", getDiffInString($ast));
}
