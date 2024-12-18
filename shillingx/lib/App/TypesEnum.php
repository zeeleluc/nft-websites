<?php

namespace App;

enum TypesEnum: string
{
    case GM = 'gm';
    case GN = 'gn';
    case REPOST = 'repost';
    case REPLY = 'reply';
    case QUESTION = 'question';
    case SHOUT = 'shout';
    case LEFT_OR_RIGHT = 'left_or_right';
    case X_CHAT_ACTION = 'x_chat_action';
    case POLL = 'poll';
    case EASY_POST = 'easy_post';
    case IMAGE = 'image';
    case HASHTAG = 'hashtag';

    public function label(): string
    {
        return match ($this) {
            self::GM => 'GM',
            self::GN => 'GN',
            self::REPOST => 'Repost',
            self::REPLY => 'Reply',
            self::QUESTION => 'Question',
            self::SHOUT => 'Shout',
            self::LEFT_OR_RIGHT => 'Left or Right',
            self::X_CHAT_ACTION => 'X Chat Action',
            self::POLL => 'Poll',
            self::EASY_POST => 'Easy Post',
            self::IMAGE => 'Image',
            self::HASHTAG => 'Hashtag',
        };
    }

    public function abbr(): string
    {
        return match ($this) {
            self::GM => 'GM',
            self::GN => 'GN',
            self::REPOST => 'Repost',
            self::REPLY => 'Reply',
            self::QUESTION => '?',
            self::SHOUT => '!',
            self::LEFT_OR_RIGHT => 'LR',
            self::X_CHAT_ACTION => 'Chat',
            self::POLL => 'Poll',
            self::EASY_POST => 'Easy Post',
            self::IMAGE => 'Image',
            self::HASHTAG => '#',
        };
    }
}
