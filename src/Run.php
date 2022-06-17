<?php

namespace Gendiff\Run;

use Docopt;

const DOCOPT_VERSION = '0.1';

const DOC = <<<DOC

Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
DOC;

function run(): void
{
    $args = @Docopt::handle(DOC, ['version' => DOCOPT_VERSION]);

}