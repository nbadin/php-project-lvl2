<?php

namespace Tests\Gendiff;

use function Gendiff\gendiff;
use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    private $stylish;
    private $plain;

    public function setUp(): void
    {
        $this->stylish = file_get_contents('./tests/fixtures/stylish.txt');
        $this->plain = file_get_contents('./tests/fixtures/plain.txt');
    }

    public function testGendiff(): void
    {
        $this->assertEquals($this->stylish, gendiff('./tests/fixtures/firstFile.json', './tests/fixtures/secondFile.json'));
        $this->assertEquals($this->plain, gendiff('./tests/fixtures/firstFile.json', './tests/fixtures/secondFile.json', 'plain'));
        $this->assertEquals($this->stylish, gendiff('./tests/fixtures/firstFile.yaml', './tests/fixtures/secondFile.yml'));
    }
}
