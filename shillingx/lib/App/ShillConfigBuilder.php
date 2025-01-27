<?php
namespace App;

use App\Object\BaseObject;

class ShillConfigBuilder extends BaseObject
{
    private int $typeGm = 1;

    private int $typeText = 0;
    private int $typeGn = 0;
    private int $typeRepost = 3;
    private int $typeReply = 20;
    private int $typeImagePigPunks = 0;
    private int $typeQuestion = 1;
    private int $typeShout = 1;
    private int $typeLeftOrRight = 1;
    private int $typeXChatAction = 0;
    private int $typePoll = 1;
    private int $typeEasyPost = 0;
    private int $typeImage = 2;
    private int $typeHashtag = 1;
    private int $typeJoke = 0;
    private int $typeGiveawayCreate = 0;
    private int $typeGiveawayWinner = 0;

    public function setTypeGiveawayCreate(int $total): ShillConfigBuilder
    {
        $this->typeGiveawayCreate = $total;

        return $this;
    }

    public function setTypePigPunksImage(int $total): ShillConfigBuilder
    {
        $this->typeImagePigPunks = $total;

        return $this;
    }

    public function setTypeGiveawayWinner(int $total): ShillConfigBuilder
    {
        $this->typeGiveawayWinner = $total;

        return $this;
    }

    public function setTypeJoke(int $total): ShillConfigBuilder
    {
        $this->typeJoke = $total;

        return $this;
    }

    public function setTypeText(int $total): ShillConfigBuilder
    {
        $this->typeText = $total;

        return $this;
    }

    public function setTypeGm(int $total): ShillConfigBuilder
    {
        $this->typeGm = $total;

        return $this;
    }

    public function setTypeGn(int $total): ShillConfigBuilder
    {
        $this->typeGn = $total;

        return $this;
    }

    public function setTypeRepost(int $total): ShillConfigBuilder
    {
        $this->typeRepost = $total;

        return $this;
    }

    public function setTypeReply(int $total): ShillConfigBuilder
    {
        $this->typeReply = $total;

        return $this;
    }

    public function setTypeQuestion(int $total): ShillConfigBuilder
    {
        $this->typeQuestion = $total;

        return $this;
    }

    public function setTypeShout(int $total): ShillConfigBuilder
    {
        $this->typeShout = $total;

        return $this;
    }

    public function setTypeLeftOrRight(int $total): ShillConfigBuilder
    {
        $this->typeLeftOrRight = $total;

        return $this;
    }

    public function setTypeGXChatAction(int $total): ShillConfigBuilder
    {
        $this->typeXChatAction = $total;

        return $this;
    }

    public function setTypePoll(int $total): ShillConfigBuilder
    {
        $this->typePoll = $total;

        return $this;
    }

    public function setTypeEasyPosts(int $total): ShillConfigBuilder
    {
        $this->typeEasyPost = $total;

        return $this;
    }

    public function setTypeImage(int $total): ShillConfigBuilder
    {
        $this->typeImage = $total;

        return $this;
    }

    public function setTypeHashtag(int $total): ShillConfigBuilder
    {
        $this->typeHashtag = $total;

        return $this;
    }

    public function toArray()
    {
        return [
            TypesEnum::EASY_POST->value => $this->typeEasyPost,
            TypesEnum::GM->value => $this->typeGm,
            TypesEnum::REPLY->value => $this->typeReply,
            TypesEnum::HASHTAG->value => $this->typeHashtag,
            TypesEnum::GIVEAWAY_WINNER->value => $this->typeGiveawayWinner,
            TypesEnum::GIVEAWAY_CREATE->value => $this->typeGiveawayCreate,
            TypesEnum::JOKE->value => $this->typeJoke,
            TypesEnum::QUESTION->value => $this->typeQuestion,
            TypesEnum::SHOUT->value => $this->typeShout,
            TypesEnum::LEFT_OR_RIGHT->value => $this->typeLeftOrRight,
            TypesEnum::X_CHAT_ACTION->value => $this->typeXChatAction,
            TypesEnum::POLL->value => $this->typePoll,
            TypesEnum::TEXT->value => $this->typeText,
            TypesEnum::IMAGE->value => $this->typeImage,
            TypesEnum::PIGPUNKS_IMAGE->value => $this->typeImagePigPunks,
            TypesEnum::REPOST->value => $this->typeRepost,
            TypesEnum::GN->value => $this->typeGn,
        ];
    }
}
