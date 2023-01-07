<?php

namespace Differ\Formatters;

function stylish($ast, $depth = 0): string
{
    $statuses = [
        'added' => '  + ',
        'deleted' => '  - ',
        'equal' => '    ',
        'hasChildren' => '    '
    ];
    $indent = str_repeat('    ', $depth);
    $result = array_map(function ($item) use ($depth, $statuses, $indent) {
        if ($item['status'] === 'deleted') {
            $value = is_array($item['value'])
                ? stylish($item['value'], $depth + 1)
                : renderValue($item['value']);

            return "{$indent}" . $statuses['deleted'] . "{$item['key']}: " . "{$value}";
        }

        if ($item['status'] === 'added') {
            $value = is_array($item['value'])
                ? stylish($item['value'], $depth + 1)
                : renderValue($item['value']);

            return "{$indent}" . $statuses['added'] . "{$item['key']}: " . "{$value}";
        }

        if ($item['status'] === 'hasChildren') {
            $value = is_array($item['value'])
                ? stylish($item['value'], $depth + 1)
                : renderValue($item['value']);

            return "{$indent}" . $statuses['hasChildren'] . "{$item['key']}: " . "{$value}";
        }

        if ($item['status'] === 'changed') {
            $oldValue = is_array($item['oldValue'])
                ? stylish($item['oldValue'], $depth + 1)
                : renderValue($item['oldValue']);

            $newValue = is_array($item['newValue'])
                ? stylish($item['newValue'], $depth + 1)
                : renderValue($item['newValue']);

            return implode("\n", [
                "{$indent}" . $statuses['deleted'] . "{$item['key']}: " . "{$oldValue}",
                "{$indent}" . $statuses['added'] . "{$item['key']}: " . "{$newValue}"
            ]);
        }

        if ($item['status'] === 'equal') {
            $value = is_array($item['value'])
            ? stylish($item['value'], $depth + 1)
            : renderValue($item['value']);

            return "{$indent}" . $statuses['equal'] . "{$item['key']}: " . "{$value}";
        }

        return '';
    }, $ast);
    return implode("\n", ['{', ...$result, "{$indent}}"]);
}

function renderValue($value)
{
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
