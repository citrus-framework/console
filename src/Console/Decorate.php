<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console;

use Citrus\Console\Decorate\ColorType;
use Citrus\Console\Decorate\GroundType;
use Citrus\Console\Decorate\StyleType;
use Citrus\Variable\Instance;

/**
 * コンソール出力文字列の装飾
 */
class Decorate
{
    use Instance;

    /** 初期化 */
    public const RESET = "\033[m";

    /** @var int[] 装飾のスタック */
    protected array $stacks = [];



    /**
     * 装飾を積む
     *
     * @param int|int[] $decorates
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
     * @return static
     */
    public function onBold(): self
    {
        $this->addStack(StyleType::BOLD->value);
        return $this;
    }

    /**
     * 下線をつける
     *
     * @return static
     */
    public function onUnderline(): self
    {
        $this->addStack(StyleType::UNDERLINE->value);
        return $this;
    }

    /**
     * 文字色をつける
     *
     * @param ColorType $colorType 色
     * @return static
     */
    public function onTextColor(ColorType $colorType): self
    {
        $this->addStack((GroundType::FOREGROUND_DEFAULT_PREFIX->value * 10) + $colorType->value);
        return $this;
    }

    /**
     * 文字色をつける(淡)
     *
     * @param ColorType $colorType 色
     * @return static
     */
    public function onTextLightColor(ColorType $colorType): self
    {
        $this->addStack((GroundType::FOREGROUND_LIGHT_PREFIX->value * 10) + $colorType->value);
        return $this;
    }

    /**
     * 背景色をつける
     *
     * @param ColorType $colorType 色
     * @return static
     */
    public function onBackColor(ColorType $colorType): self
    {
        $this->addStack((GroundType::BACKGROUND_DEFAULT_PREFIX->value * 10) + $colorType->value);
        return $this;
    }

    /**
     * 背景色をつける(淡)
     *
     * @param ColorType $colorType 色
     * @return static
     */
    public function onBackLightColor(ColorType $colorType): self
    {
        $this->addStack((GroundType::BACKGROUND_LIGHT_PREFIX->value * 10) + $colorType->value);
        return $this;
    }
}
