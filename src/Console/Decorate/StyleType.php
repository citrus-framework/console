<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console\Decorate;

/**
 * コンソール出力スタイル
 */
enum StyleType: int
{
    /** 太字 */
    case BOLD = 1;

    /** 仄暗くする */
    case DIM = 2;

    /** イタリック */
    case ITALIC = 3;

    /** 下線 */
    case UNDERLINE = 4;

    /** 点滅 */
    case BLINK = 5;

    /** 高速点滅 */
    case HIGH_SPEED_BLINK = 6;

    /** 反転 */
    case REVERSE = 7;

    /** 隠す */
    case HIDDEN = 8;

    /** 取り消し線 */
    case LINE_THROUGH = 9;
}
