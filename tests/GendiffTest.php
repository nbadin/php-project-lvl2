<?php

namespace Tests\Differ;

use function Differ\Differ\gendiff;
use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    private $stylish;
    private $plain;
    private $json;

    public function setUp(): void
    {
        $this->stylish = file_get_contents('./tests/fixtures/expectedStylish.txt');
        $this->plain = file_get_contents('./tests/fixtures/expectedPlain.txt');
        $this->json = file_get_contents('./tests/fixtures/expectedJson.txt');
    }

    public function testGendiff(): void
    {
        $this->assertEquals($this->stylish, gendiff('./tests/fixtures/firstFile.json', './tests/fixtures/secondFile.json'));
        $this->assertEquals($this->plain, gendiff('./tests/fixtures/firstFile.json', './tests/fixtures/secondFile.json', 'plain'));
        $this->assertEquals($this->stylish, gendiff('./tests/fixtures/firstFile.yaml', './tests/fixtures/secondFile.yml'));
        $this->assertEquals($this->json, gendiff('./tests/fixtures/firstFile.yaml', './tests/fixtures/secondFile.yml', 'json'));
    }
}
