<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console;

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
     * @return void
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
     * @return void
     */
    public function writeln(array|string $messages): void
    {
        $this->write($messages, true);
    }



    /**
     * メッセージフォーマット(改行)
     *
     * @param string $format フォーマット文字列
     * @param mixed  $args   可変引数
     * @return void
     */
    public function format(string $format, ...$args): void
    {
        $this->writeln(vsprintf($format, $args));
    }



    /**
     * 成功時出力
     *
     * @param string $message メッセージ
     * @return void
     */
    public function success(string $message): void
    {
        // 装飾
        $decorate = new Decorate();
        $decorate->onTextLightColor(Decorate::GREEN);
        $decorate->onBold();
        $decorated_message = $decorate->format($message);
        // 出力
        $this->writeln($decorated_message);
    }



    /**
     * 失敗時出力
     *
     * @param string $message メッセージ
     * @return void
     */
    public function failure(string $message): void
    {
        // 装飾
        $decorate = new Decorate();
        $decorate->onTextLightColor(Decorate::WHITE);
        $decorate->onBackColor(Decorate::RED);
        $decorate->onBold();
        $decorated_message = $decorate->format($message);
        // 出力
        $this->writeln($decorated_message);
    }
}
