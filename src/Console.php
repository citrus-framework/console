<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus;

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
        if (0 === count($this->options))
        {
            return;
        }

        $this->parameters = getopt('', $this->options);
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
     *
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
     *
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
