<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Console;

/**
 * コマンドが受け取る引数の受け取り方
 */
enum OptionKind
{
    /** 値を取らない(`getopt` の形で名前にコロンが無い。例：`dry-run`) */
    case FLAG;

    /** 値が要る(コロンが1つ。例：`account:`) */
    case REQUIRED;

    /** 値を省ける(コロンが2つ。例：`level::`) */
    case OPTIONAL;
}
