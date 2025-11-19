<?php

namespace App\Enums;

/**
 * コマンド（Artisan）の実行結果を表す Enum。
 *
 * - SUCCESS: 正常終了（エラーなし）
 * - PARTIAL_FAILURE: 部分失敗あり（処理継続 → 結果として失敗扱い）
 * - FAILURE: 致命的エラーにより異常終了
 */
enum CommandStatus: int
{
    /** 全て成功（エラーなし） */
    case SUCCESS = 0;

    /** 部分的にエラーがあったが処理は継続した */
    case PARTIAL_FAILURE = 1;

    /** 想定外の例外など、致命的な失敗 */
    case FAILURE = 2;

    /**
     * Laravel コマンドの戻り値として利用するための便利メソッド
     *
     * @return int Artisan の終了コード
     */
    public function code(): int
    {
        return $this->value;
    }

    /**
     * 結果をログ出力用のメッセージに変換する（任意）
     */
    public function label(): string
    {
        return match ($this) {
            self::SUCCESS          => 'SUCCESS',
            self::PARTIAL_FAILURE  => 'PARTIAL FAILURE',
            self::FAILURE          => 'FAILURE',
        };
    }
}
