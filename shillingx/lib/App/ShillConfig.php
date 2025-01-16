<?php
namespace App;

use App\Object\BaseObject;

class ShillConfig extends BaseObject
{

    public static function get(): array
    {
        return [
            ProjectsEnum::PIGPUNKS->value => self::getConfigPigPunks(),
            ProjectsEnum::RIPPLEPUNKS->value => self::getConfigRipplePunks(),
            ProjectsEnum::NOBASED->value => self::getConfigNoBased(),
            ProjectsEnum::HASMINTS->value => self::getConfigHasMints(),
            ProjectsEnum::LOADINGPUNKS->value => self::getConfigLoadingPunks(),
            ProjectsEnum::LOONEYLUKE->value => self::getConfigLooneyLuke(),
            ProjectsEnum::BASEALIENS->value => self::getConfigBaseAliens(),
        ];
    }

    private static function getConfigNoBased()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeGXChatAction(0);
        $builder->setTypeReply(0);
        $builder->setTypeImage(1);
        $builder->setTypeRepost(1);
        $builder->setTypeJoke(0);
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypeLeftOrRight(1);
        $builder->setTypeText(1);
        $builder->setTypePoll(0);

        return $builder->toArray();
    }

    private static function getConfigPigPunks()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeGXChatAction(0);
        $builder->setTypeReply(0);
        $builder->setTypeImage(1);
        $builder->setTypeRepost(1);
        $builder->setTypeJoke(0);
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypePoll(0);
        $builder->setTypeLeftOrRight(1);
        $builder->setTypeText(1);

        return $builder->toArray();
    }

    private static function getConfigLoadingPunks()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypePoll(0);
        $builder->setTypeRepost(0);
        $builder->setTypeReply(0);
        $builder->setTypeGm(0);
        $builder->setTypeGn(0);
        $builder->setTypeImage(1);
        $builder->setTypeJoke(0);

        return $builder->toArray();
    }

    private static function getConfigHasMints()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeEasyPosts(0);
        $builder->setTypeReply(50);
        $builder->setTypeJoke(0);
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypeImage(0);
        $builder->setTypeLeftOrRight(0);
        $builder->setTypeText(6);
        $builder->setTypePigPunksImage(2);
        $builder->setTypeGiveawayCreate(1);
        $builder->setTypeGiveawayWinner(1);

        return $builder->toArray();
    }

    private static function getConfigRipplePunks()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeRepost(1);
        $builder->setTypeReply(0);
        $builder->setTypeImage(1);
        $builder->setTypeText(1);
        $builder->setTypeJoke(0);
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypePoll(0);

        return $builder->toArray();
    }

    private static function getConfigLooneyLuke()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeGm(0);
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypePoll(0);
        $builder->setTypeRepost(0);
        $builder->setTypeReply(0);
        $builder->setTypeGn(0);
        $builder->setTypeImage(1);
        $builder->setTypeJoke(0);

        return $builder->toArray();
    }

    private static function getConfigBaseAliens()
    {
        $builder = new ShillConfigBuilder();
        $builder->setTypeGm(0);
        $builder->setTypeQuestion(0);
        $builder->setTypeShout(0);
        $builder->setTypePoll(0);
        $builder->setTypeRepost(0);
        $builder->setTypeReply(0);
        $builder->setTypeGn(0);
        $builder->setTypeImage(1);
        $builder->setTypeJoke(0);

        return $builder->toArray();
    }
}
