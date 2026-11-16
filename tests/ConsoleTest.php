<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test;

use Citrus\Console;
use Citrus\Console\OptionKind;
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

    #[Test]
    public function 引数の受け取り方がコロン無しのみ()
    {
        $command = new TestOptionConsole(['verbose', 'dry-run']);

        $this->assertSame(['verbose' => OptionKind::FLAG, 'dry-run' => OptionKind::FLAG], $command->optionKinds());
    }

    #[Test]
    public function 引数の受け取り方がコロン1つのみ()
    {
        $command = new TestOptionConsole(['account:']);

        $this->assertSame(['account' => OptionKind::REQUIRED], $command->optionKinds());
    }

    #[Test]
    public function 引数の受け取り方がコロン2つのみ()
    {
        $command = new TestOptionConsole(['level::']);

        $this->assertSame(['level' => OptionKind::OPTIONAL], $command->optionKinds());
    }

    #[Test]
    public function 引数の受け取り方が混ざっていても名前ごとに取れる()
    {
        $command = new TestOptionConsole(['account:', 'dry-run', 'level::']);

        $this->assertSame([
            'account' => OptionKind::REQUIRED,
            'dry-run' => OptionKind::FLAG,
            'level' => OptionKind::OPTIONAL,
        ], $command->optionKinds());
    }

    #[Test]
    public function 引数が空なら受け取り方も空()
    {
        $command = new TestOptionConsole([]);

        $this->assertSame([], $command->optionKinds());
    }

    #[Test]
    public function 引数の添字が連番でなくても受け取り方は名前がキー()
    {
        $command = new TestOptionConsole([2 => 'account:', 'key' => 'verbose']);

        $this->assertSame(['account' => OptionKind::REQUIRED, 'verbose' => OptionKind::FLAG], $command->optionKinds());
    }

    #[Test]
    public function プロパティの初期値で書いた引数の受け取り方が取れる()
    {
        $command = new TestDefaultOptionConsole();

        $this->assertSame(['account' => OptionKind::REQUIRED, 'verbose' => OptionKind::FLAG], $command->optionKinds());
    }

    #[Test]
    public function 値なしで付いた引数は付いていると判定される()
    {
        $command = new TestParameterConsole(['dry-run' => false]);

        $this->assertTrue($command->hasParameter('dry-run'));
    }

    #[Test]
    public function 文字列の値が付いた引数は付いていると判定される()
    {
        $command = new TestParameterConsole(['account' => 'a']);

        $this->assertTrue($command->hasParameter('account'));
    }

    #[Test]
    public function 無い名前の引数は付いていないと判定される()
    {
        $command = new TestParameterConsole(['account' => 'a']);

        $this->assertFalse($command->hasParameter('none'));
    }

    #[Test]
    public function 文字列の値はそのまま取れる()
    {
        $command = new TestParameterConsole(['account' => 'a']);

        $this->assertSame('a', $command->parameter('account', 'x'));
    }

    #[Test]
    public function 値なしで付いた引数はデフォルト値のnullが取れる()
    {
        $command = new TestParameterConsole(['dry-run' => false]);

        $this->assertNull($command->parameter('dry-run'));
    }

    #[Test]
    public function 値なしで付いた引数は指定したデフォルト値が取れる()
    {
        $command = new TestParameterConsole(['level' => false]);

        $this->assertSame('x', $command->parameter('level', 'x'));
    }

    #[Test]
    public function 無い名前の引数はデフォルト値が取れる()
    {
        $command = new TestParameterConsole([]);

        $this->assertNull($command->parameter('none'));
        $this->assertSame('x', $command->parameter('none', 'x'));
    }

    #[Test]
    public function 本物のgetoptで読んだ引数が取れる()
    {
        $script = __DIR__ . '/Fixture/read_parameters.php';
        $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($script) . ' --dry-run --level --account=a 2>&1';
        exec($command, $lines, $code);

        $this->assertSame(0, $code);
        $this->assertSame([
            'has' => ['dry-run' => true, 'level' => true, 'account' => true, 'none' => false],
            'value' => ['dry-run' => null, 'level' => 'x', 'account' => 'a', 'none' => 'y'],
        ], json_decode(implode('', $lines), true));
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
 * 引数の値(getopt の結果)を指定するためのテストコマンド
 */
class TestParameterConsole extends Console
{
    /**
     * @param array $parameters getopt の結果
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }
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
