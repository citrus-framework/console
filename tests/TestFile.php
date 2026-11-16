<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusConsole. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test;

/**
 * テスト処理で利用するファイル関係の処理
 */
trait TestFile
{
    /**
     * 指定のパス配下を全て(パスも含め)削除
     * @param string $path
     */
    public function forceRemove(string $path): void
    {
        // ファイル、もしくはディレクトリとして認識されない
        if (file_exists($path) === false)
        {
            return;
        }

        // ファイルなら削除
        if (is_file($path) === true)
        {
            unlink($path);
            return;
        }

        // ディレクトリなら走査して削除していく
        // 配下の情報を取得
        $children = scandir($path);
        foreach ($children as $child)
        {
            // ノイズになるカレントはスルー
            if (in_array($child, ['.', '..'], true) === true)
            {
                continue;
            }

            // 配下要素のパス
            $child_path = sprintf('%s%s%s',
                $path,
                DIRECTORY_SEPARATOR,
                $child
                );

            // 再起する
            $this->forceRemove($child_path);
        }

        // 処理対象のディレクトリも削除
        rmdir($path);
    }
}