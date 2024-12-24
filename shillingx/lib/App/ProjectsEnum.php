<?php

namespace App;

enum ProjectsEnum: string
{
    case BASEALIENS = 'basealiens';
    case PIGPUNKS = 'pigpunks';
    case HASMINTS = 'hasmints';
    case NOGENS = 'nogens';
    case NOBASED = 'nobased';
    case RIPPLEPUNKS = 'ripplepunks';
    case LOADINGPUNKS = 'loadingpunks';
    case LOONEYLUKE = 'looneyluke';

    public function label(): string
    {
        return match ($this) {
            self::BASEALIENS => 'BaseAliens',
            self::PIGPUNKS => 'Pig Punks',
            self::HASMINTS => 'Has Mints',
            self::NOGENS => 'NO:GENERATES',
            self::NOBASED => 'No-Based',
            self::RIPPLEPUNKS => 'Ripple Punks',
            self::LOADINGPUNKS => 'Loading Punks',
            self::LOONEYLUKE => 'Looney Luke',
        };
    }

    public function abbr(): string
    {
        return match ($this) {
            self::BASEALIENS => 'BA',
            self::PIGPUNKS => 'PP',
            self::HASMINTS => 'HM',
            self::NOGENS => 'NG',
            self::NOBASED => 'NB',
            self::RIPPLEPUNKS => 'RP',
            self::LOADINGPUNKS => 'LP',
            self::LOONEYLUKE => 'LL',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::BASEALIENS => '👽',
            self::PIGPUNKS => '🐽',
            self::HASMINTS => '💦',
            self::NOGENS => '🟩',
            self::NOBASED => '✊🏻',
            self::RIPPLEPUNKS => '👑',
            self::LOADINGPUNKS => '🔃',
            self::LOONEYLUKE => '🧢',
        };
    }
}
