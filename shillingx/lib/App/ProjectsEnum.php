<?php

namespace App;

enum ProjectsEnum: string
{
    case NOBASED = 'nobased';
    case RIPPLEPUNKS = 'ripplepunks';
    case HASMINTS = 'hasmints';
    case LOADINGPUNKS = 'loadingpunks';
    case LOONEYLUKE = 'looneyluke';
    case PIGPUNKS = 'pigpunks';

    public function label(): string
    {
        return match ($this) {
            self::NOBASED => 'No-Based',
            self::RIPPLEPUNKS => 'Ripple Punks',
            self::HASMINTS => 'Has Mints',
            self::LOADINGPUNKS => 'Loading Punks',
            self::LOONEYLUKE => 'Looney Luke',
            self::PIGPUNKS => 'Pig Punks',
        };
    }

    public function abbr(): string
    {
        return match ($this) {
            self::NOBASED => 'NB',
            self::RIPPLEPUNKS => 'RP',
            self::HASMINTS => 'HM',
            self::LOADINGPUNKS => 'LP',
            self::LOONEYLUKE => 'LL',
            self::PIGPUNKS => 'PP',
        };
    }
}
