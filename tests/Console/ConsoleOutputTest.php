<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Console;

use Citrus\Console\ConsoleOutput;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * コマンドコンソールのテスト
 */
class ConsoleOutputTest extends TestCase
{
    #[Test]
    public function 文字出力で例外が発生しない()
    {
        $command = new TestConsole();

        $command->write('TEST', true);
        $command->writeln('TEST');
        $command->format('TES%s', 'T');
        $command->success('TEST');
        $command->failure('TEST');
    }

    #[Test]
    public function 配列を渡すと要素だけが出力される()
    {
        // テストでは UNIT_TEST が定義されていて write が出力しないので、定義しない別の PHP で実行する
        $script = __DIR__ . '/../Fixture/write_array.php';
        $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($script) . ' 2>&1';
        exec($command, $lines, $code);

        $this->assertSame(0, $code);
        $this->assertSame(['A', 'B', 'CD'], $lines);
    }
}

/**
 * トレイト反映用のテストコマンド
 */
class TestConsole
{
    use ConsoleOutput;
}
