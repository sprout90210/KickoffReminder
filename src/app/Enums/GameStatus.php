<?php

namespace App\Enums;

enum GameStatus: string
{
    // 試合前
    case SCHEDULED = 'SCHEDULED';
    // 試合直前（Kickoff 時間前）
    case TIMED     = 'TIMED';     
    // 試合中
    case IN_PLAY   = 'IN_PLAY';   
    // ハーフタイムなど
    case PAUSED    = 'PAUSED';    
    // 試合終了
    case FINISHED  = 'FINISHED';  
    // 延期
    case POSTPONED = 'POSTPONED'; 
    // 中止
    case CANCELED  = 'CANCELED';  
    // 中断
    case SUSPENDED = 'SUSPENDED'; 

    public static function reminderTargets(): array
    {
        return [self::SCHEDULED, self::TIMED];
    }

    public static function resultTargets(): array
    {
        return [self::IN_PLAY, self::FINISHED];
    }

    public static function upcomingTargets(): array
    {
        return [self::IN_PLAY, self::TIMED];
    }
}
