<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console\Decorate;

/**
 * コンソール出力のバックグラウンド・フォアグラウンド
 */
enum GroundType: int
{
    /** 文字色デフォルトカラー接頭辞 */
    case FOREGROUND_DEFAULT_PREFIX = 3;

    /** 文字色ライトカラー接頭辞 */
    case FOREGROUND_LIGHT_PREFIX = 9;

    /** 背景色デフォルトカラー接頭辞 */
    case BACKGROUND_DEFAULT_PREFIX = 4;

    /** 背景色ライトカラー接頭辞 */
    case BACKGROUND_LIGHT_PREFIX = 10;
}
