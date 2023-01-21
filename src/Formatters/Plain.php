<?php

namespace Differ\Formatters\Plain;

function formatterOfType($value)
{
    if (is_array($value)) {
        return '[complex value]';
    }

    if (gettype($value) === 'string') {
        return "'{$value}'";
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
    return $value;
}

function getDiffInString($ast, $parents = [])
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

function plain($ast)
{
    return implode("\n", getDiffInString($ast));
}
