<?php
namespace App;

use App\Object\BaseObject;

class ShillConfigBuilder extends BaseObject
{
    private int $typeGm = 1;
    private int $typeGn = 1;
    private int $typeRepost = 3;
    private int $typeReply = 10;
    private int $typeQuestion = 1;
    private int $typeShout = 1;
    private int $typeLeftOrRight = 1;
    private int $typeXChatAction = 0;
    private int $typePoll = 1;

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

    public function toArray()
    {
        return [
            TypesEnum::GM->value => $this->typeGm,
            TypesEnum::REPOST->value => $this->typeRepost,
            TypesEnum::REPLY->value => $this->typeReply,
            TypesEnum::QUESTION->value => $this->typeQuestion,
            TypesEnum::SHOUT->value => $this->typeShout,
            TypesEnum::LEFT_OR_RIGHT->value => $this->typeLeftOrRight,
            TypesEnum::X_CHAT_ACTION->value => $this->typeXChatAction,
            TypesEnum::POLL->value => $this->typePoll,
            TypesEnum::GN->value => $this->typeGm,
        ];
    }
}
