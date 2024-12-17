<?php
namespace App;

use App\Object\BaseObject;

class ShillConfig extends BaseObject
{

    public static function get(): array
    {
        return [
            ProjectsEnum::NOBASED->value => self::getConfigNoBased(),
            ProjectsEnum::PIGPUNKS->value => self::getConfigPigPunks(),
            ProjectsEnum::LOADINGPUNKS->value => self::getConfigLoadingPunks(),
            ProjectsEnum::HASMINTS->value => self::getConfigHasMints(),
            ProjectsEnum::RIPPLEPUNKS->value => self::getConfigRipplePunks(),
            ProjectsEnum::LOONEYLUKE->value => self::getConfigLooneyLuke(),
        ];
    }

    private static function getConfigNoBased()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeGXChatAction(1);

        return $builder->toArray();
    }

    private static function getConfigPigPunks()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeGXChatAction(1);
        $builder->setTypeReply(200);
        $builder->setTypeRepost(5);

        return $builder->toArray();
    }

    private static function getConfigLoadingPunks()
    {
        $builder = new ShillConfigBuilder();

        return $builder->toArray();
    }

    private static function getConfigHasMints()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeEasyPosts(1);

        return $builder->toArray();
    }

    private static function getConfigRipplePunks()
    {
        $builder = new ShillConfigBuilder();

        return $builder->toArray();
    }

    private static function getConfigLooneyLuke()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeReply(100);

        return $builder->toArray();
    }
}
