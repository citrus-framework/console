<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus;

use Citrus\Console\OptionKind;

/**
 * コンソールコマンド処理
 */
class Console
{
    /** @var string script code */
    protected string $script = '';

    /** @var array configure */
    protected array $configures = [];

    /** @var string[] command options */
    protected array $options = [];

    /** @var array command parameters */
    protected array $parameters = [];

    /**
     * コマンドライン引数のパース処理
     */
    public function options(): void
    {
        // コマンドライン引数がなければ処理スキップ
        if (count($this->options) === 0)
        {
            return;
        }

        $this->parameters = getopt('', $this->options);
    }

    /**
     * コマンドが受け取る引数の名前一覧取得(`$options` からコロンを外した名前)
     * @return string[] 引数の名前一覧
     */
    public function optionNames(): array
    {
        return array_values(array_map(fn (string $option): string => rtrim($option, ':'), $this->options));
    }

    /**
     * コマンドが受け取る引数ごとの受け取り方取得(`$options` のコロンの数で決まる)
     * @return array<string, OptionKind> 引数の名前をキーにした受け取り方
     */
    public function optionKinds(): array
    {
        $kinds = [];
        foreach ($this->options as $option)
        {
            $name = rtrim($option, ':');
            $kinds[$name] = match (strlen($option) - strlen($name))
            {
                0 => OptionKind::FLAG,
                1 => OptionKind::REQUIRED,
                default => OptionKind::OPTIONAL,
            };
        }

        return $kinds;
    }

    /**
     * コマンド実行処理
     */
    public function execute(): void
    {
    }

    /**
     * コマンド実行前処理
     */
    public function before(): void
    {
    }

    /**
     * コマンド実行後処理
     */
    public function after(): void
    {
    }

    /**
     * コマンドラインオプションパラメータ取得
     * @param string      $key     パラメータキー
     * @param string|null $default デフォルト値
     * @return string|null パラメータ値
     */
    public function parameter(string $key, ?string $default = null): ?string
    {
        return ($this->parameters[$key] ?? $default);
    }

    /**
     * コマンドランナー
     * @param array $configures 設定情報
     */
    public static function runner(array $configures): void
    {
        $command = new static();
        $command->configures = $configures;
        $command->options();
        $command->before();
        $command->execute();
        $command->after();
    }
}
