<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Console;

use Citrus\Console\Decorate;
use Citrus\Console\Decorate\ColorType;
use Citrus\Console\Decorate\StyleType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * コマンドコンソール装飾のテスト
 */
class DecorateTest extends TestCase
{
    #[Test]
    public function 文字に色をつけて出力()
    {
        // メッセージ
        $message = ' TEST ';

        // 装飾
        $decorate = new Decorate();

        // 文字色(赤)
        $decorate->onTextColor(ColorType::RED);
        $output = $decorate->format($message);
        $this->debugOutput($output);

        // 背景色(シアン)
        $decorate->onBackColor(ColorType::CYAN);
        $output = $decorate->format($message);
        $this->debugOutput($output);

        // 太字
        $decorate->onBold();
        $output = $decorate->format($message);
        $this->debugOutput($output);

        // 下線
        $decorate->onUnderline();
        $output = $decorate->format($message);
        $this->debugOutput($output);

        // 点滅
        $decorate->addStack(StyleType::BLINK->value);
        $output = $decorate->format($message);
        $this->debugOutput($output);

        // 反転
        $decorate->addStack(StyleType::REVERSE->value);
        $output = $decorate->format($message);
        $this->debugOutput($output);
    }

    #[Test]
    public function 配列で積んだ装飾は要素だけが積まれる()
    {
        $decorate = new Decorate();
        $decorate->addStack([StyleType::BOLD->value, StyleType::UNDERLINE->value]);

        $this->assertSame(
            sprintf("\033[%d;%dm TEST %s", StyleType::BOLD->value, StyleType::UNDERLINE->value, Decorate::RESET),
            $decorate->format(' TEST '),
        );
    }

    #[Test]
    public function 空の配列では装飾が積まれない()
    {
        $decorate = new Decorate();
        $decorate->addStack([]);

        $this->assertSame(sprintf("\033[m TEST %s", Decorate::RESET), $decorate->format(' TEST '));
    }

    /**
     * 目視用のデバッグプリント
     * @param string $message
     * @return void
     */
    private function debugOutput(string $message): void
    {
//        echo $message . "\n";
    }
}
