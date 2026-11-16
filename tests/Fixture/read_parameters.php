<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

/**
 * 付けられた `--dry-run --level --account=a` を getopt で読んだときの hasParameter・parameter の結果を JSON で出す、テストから起動するスクリプト
 *
 * tests/bootstrap.php は読まない
 */

use Citrus\Console;

require __DIR__ . '/../../vendor/autoload.php';

$command = new class () extends Console {
    /** @var string[] command options */
    protected array $options = ['dry-run', 'level::', 'account:'];
};

// 引数は、テストが `--dry-run --level --account=a` を付けて起動する
$command->options();

echo json_encode([
    'has' => [
        'dry-run' => $command->hasParameter('dry-run'),
        'level' => $command->hasParameter('level'),
        'account' => $command->hasParameter('account'),
        'none' => $command->hasParameter('none'),
    ],
    'value' => [
        'dry-run' => $command->parameter('dry-run'),
        'level' => $command->parameter('level', 'x'),
        'account' => $command->parameter('account'),
        'none' => $command->parameter('none', 'y'),
    ],
]);
echo PHP_EOL;
