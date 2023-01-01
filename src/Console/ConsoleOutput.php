<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console;

use Citrus\Console\Decorate\ColorType;

/**
 * コンソール出力系処理
 */
trait ConsoleOutput
{
    /**
     * メッセージ出力
     *
     * @param string|string[] $messages 出力メッセージ
     * @param bool            $newline  改行
     */
    public function write(array|string $messages, bool $newline): void
    {
        // 配列なら再起
        if (true === is_array($messages))
        {
            foreach ($messages as $message)
            {
                $this->write($message, $newline);
            }
        }

        // テスト時は出力をせずにreturn
        if (true === defined('UNIT_TEST') && true === UNIT_TEST)
        {
            return;
        }

        // 出力
        echo $messages . (true === $newline ? PHP_EOL : '');
    }

    /**
     * メッセージ出力(改行)
     *
     * @param string|string[] $messages メッセージ
     */
    public function writeln(array|string $messages): void
    {
        $this->write($messages, true);
    }

    /**
     * メッセージフォーマット(改行)
     *
     * @param string                $format フォーマット文字列
     * @param string|int|float|bool $args   可変引数
     */
    public function format(string $format, ...$args): void
    {
        $this->writeln(vsprintf($format, $args));
    }

    /**
     * 成功時出力
     *
     * @param string $message メッセージ
     */
    public function success(string $message): void
    {
        // 出力
        $this->writeln(
            // 装飾してフォーマット
            Decorate::getInstance()
                ->onTextLightColor(ColorType::GREEN)
                ->onBold()
                ->format($message)
        );
    }

    /**
     * 失敗時出力
     *
     * @param string $message メッセージ
     */
    public function failure(string $message): void
    {
        // 出力
        $this->writeln(
            // 装飾してフォーマット
            Decorate::getInstance()
                ->onTextLightColor(ColorType::WHITE)
                ->onBackColor(ColorType::RED)
                ->onBold()
                ->format($message)
        );
    }
}
