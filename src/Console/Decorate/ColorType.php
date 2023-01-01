<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console\Decorate;

/**
 * コンソール出力文字色
 */
enum ColorType: int
{
    /** 黒 */
    case BLACK = 0;

    /** 赤 */
    case RED = 1;

    /** 緑 */
    case GREEN = 2;

    /** 黄色 */
    case YELLOW = 3;

    /** 青 */
    case BLUE = 4;

    /** マジェンタ */
    case MAGENTA = 5;

    /** シアン */
    case CYAN = 6;

    /** 白 */
    case WHITE = 7;
}
