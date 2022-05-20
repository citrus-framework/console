<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console;

/**
 * コンソール出力文字列の装飾
 */
class Decorate
{
    /** @var int 文字色デフォルトカラー接頭辞 */
    public const FOREGROUND_DEFAULT_PREFIX = 3;

    /** @var int 文字色ライトカラー接頭辞 */
    public const FOREGROUND_LIGHT_PREFIX = 9;

    /** @var int 背景色デフォルトカラー接頭辞 */
    public const BACKGROUND_DEFAULT_PREFIX = 4;

    /** @var int 背景色ライトカラー接頭辞 */
    public const BACKGROUND_LIGHT_PREFIX = 10;

    /** @var int 黒 */
    public const BLACK = 0;

    /** @var int 赤 */
    public const RED = 1;

    /** @var int 緑 */
    public const GREEN = 2;

    /** @var int 黄色 */
    public const YELLOW = 3;

    /** @var int 青 */
    public const BLUE = 4;

    /** @var int マジェンタ */
    public const MAGENTA = 5;

    /** @var int シアン */
    public const CYAN = 6;

    /** @var int 白 */
    public const WHITE = 7;

    /** @var int 太字 */
    public const BOLD = 1;

    /** @var int 仄暗くする */
    public const DIM = 2;

    /** @var int 下線 */
    public const UNDERLINE = 4;

    /** @var int 点滅 */
    public const BLINK = 5;

    /** @var int 反転 */
    public const REVERSE = 7;

    /** @var int 隠す */
    public const HIDDEN = 8;

    /** @var string 初期化 */
    public const RESET = "\033[m";

    /** @var int[] 装飾のスタック */
    protected array $stacks = [];



    /**
     * 装飾を積む
     *
     * @param int|int[] $decorates
     * @return void
     */
    public function addStack(array|int $decorates): void
    {
        // 配列の場合は再起
        if (true === is_array($decorates))
        {
            foreach ($decorates as $decorate)
            {
                $this->addStack($decorate);
            }
        }

        $this->stacks[] = $decorates;
    }



    /**
     * 装飾済み文字列の返却
     *
     * @param string $message
     * @return string
     */
    public function format(string $message): string
    {
        $decorate_code = implode(';', $this->stacks);

        return sprintf(
            "\033[%sm%s%s",
            $decorate_code,
            $message,
            self::RESET
        );
    }



    /**
     * 太字にする
     *
     * @return void
     */
    public function onBold(): void
    {
        $this->addStack(self::BOLD);
    }



    /**
     * 下線をつける
     *
     * @return void
     */
    public function onUnderline(): void
    {
        $this->addStack(self::UNDERLINE);
    }



    /**
     * 文字色をつける
     *
     * @param int $color 色
     * @return void
     */
    public function onTextColor(int $color): void
    {
        $this->addStack((self::FOREGROUND_DEFAULT_PREFIX * 10) + $color);
    }



    /**
     * 文字色をつける(淡)
     *
     * @param int $color 色
     * @return void
     */
    public function onTextLightColor(int $color): void
    {
        $this->addStack((self::FOREGROUND_LIGHT_PREFIX * 10) + $color);
    }



    /**
     * 背景色をつける
     *
     * @param int $color 色
     * @return void
     */
    public function onBackColor(int $color): void
    {
        $this->addStack((self::BACKGROUND_DEFAULT_PREFIX * 10) + $color);
    }



    /**
     * 背景色をつける(淡)
     *
     * @param int $color 色
     * @return void
     */
    public function onBackLightColor(int $color): void
    {
        $this->addStack((self::BACKGROUND_LIGHT_PREFIX * 10) + $color);
    }
}
