<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test;

use Citrus\Console;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * コンソールコマンド処理のテスト
 */
class ConsoleTest extends TestCase
{
    #[Test]
    public function 引数の名前一覧からコロンが外れる()
    {
        $command = new TestOptionConsole(['account:', 'verbose', 'level::']);

        $this->assertSame(['account', 'verbose', 'level'], $command->optionNames());
    }

    #[Test]
    public function 引数の名前一覧がコロン無しのみ()
    {
        $command = new TestOptionConsole(['verbose', 'debug']);

        $this->assertSame(['verbose', 'debug'], $command->optionNames());
    }

    #[Test]
    public function 引数の名前一覧がコロン1つのみ()
    {
        $command = new TestOptionConsole(['account:']);

        $this->assertSame(['account'], $command->optionNames());
    }

    #[Test]
    public function 引数の名前一覧がコロン2つのみ()
    {
        $command = new TestOptionConsole(['level::']);

        $this->assertSame(['level'], $command->optionNames());
    }

    #[Test]
    public function 引数が空なら名前一覧も空()
    {
        $command = new TestOptionConsole([]);

        $this->assertSame([], $command->optionNames());
    }

    #[Test]
    public function プロパティの初期値で書いた引数の名前一覧が取れる()
    {
        $command = new TestDefaultOptionConsole();

        $this->assertSame(['account', 'verbose'], $command->optionNames());
    }

    #[Test]
    public function 引数の添字が連番でなくても名前一覧は連番()
    {
        $command = new TestOptionConsole([2 => 'account:', 'key' => 'verbose']);

        $this->assertSame(['account', 'verbose'], $command->optionNames());
    }
}

/**
 * 実際のコマンドと同じく、プロパティの初期値で引数を書いたテストコマンド
 */
class TestDefaultOptionConsole extends Console
{
    /** @var string[] command options */
    protected array $options = ['account:', 'verbose'];
}

/**
 * 引数を指定するためのテストコマンド
 */
class TestOptionConsole extends Console
{
    /**
     * @param string[] $options 引数
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }
}
