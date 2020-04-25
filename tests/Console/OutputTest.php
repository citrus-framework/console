<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Console;

use Citrus\Console\ConsoleOutput;
use PHPUnit\Framework\TestCase;

/**
 * コマンドコンソールのテスト
 */
class ConsoleTest extends TestCase
{
    /**
     * @test
     */
    public function 文字出力で例外が発生しない()
    {
        $command = new TestConsole();

        $command->write('TEST', true);
        $command->writeln('TEST');
        $command->format('TES%s', 'T');
        $command->success('TEST');
        $command->failure('TEST');
    }
}

/**
 * トレイト反映用のテストコマンド
 */
class TestConsole
{
    use ConsoleOutput;
}
