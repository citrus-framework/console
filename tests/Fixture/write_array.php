<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

/**
 * ConsoleOutput::write に配列を渡したときの出力を確かめるための、テストから起動するスクリプト
 *
 * tests/bootstrap.php は読まない(UNIT_TEST を定義すると、write が出力しないため)
 */

use Citrus\Console\ConsoleOutput;

require __DIR__ . '/../../vendor/autoload.php';

$output = new class () {
    use ConsoleOutput;
};

$output->write(['A', 'B'], true);
$output->write(['C', 'D'], false);
$output->write([], true);
