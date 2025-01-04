<?php

namespace App;

enum TypesEnum: string
{
    case GM = 'gm';
    case GN = 'gn';
    case PIGPUNKS_IMAGE = 'pigpunks_image';
    case TEXT = 'text';
    case GIVEAWAY_CREATE = 'giveaway_create';
    case GIVEAWAY_WINNER = 'giveaway_winner';
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
    case JOKE = 'joke';

    public function label(): string
    {
        return match ($this) {
            self::JOKE => 'Joke',
            self::GM => 'GM',
            self::GN => 'GN',
            self::GIVEAWAY_CREATE => 'Giveaway Create',
            self::GIVEAWAY_WINNER => 'Giveaway Winner',
            self::TEXT => 'Text',
            self::REPOST => 'Repost',
            self::REPLY => 'Reply',
            self::QUESTION => 'Question',
            self::SHOUT => 'Shout',
            self::LEFT_OR_RIGHT => 'Left or Right',
            self::X_CHAT_ACTION => 'X Chat Action',
            self::POLL => 'Poll',
            self::EASY_POST => 'Easy Post',
            self::IMAGE => 'Image',
            self::PIGPUNKS_IMAGE => 'Image PigPunks',
            self::HASHTAG => 'Hashtag',
        };
    }

    public function abbr(): string
    {
        return match ($this) {
            self::JOKE => 'Joke',
            self::GM => 'GM',
            self::GN => 'GN',
            self::GIVEAWAY_CREATE => 'Giveaway Create',
            self::GIVEAWAY_WINNER => 'Giveaway Winner',
            self::TEXT => 'Text',
            self::REPOST => 'Repost',
            self::REPLY => 'Reply',
            self::QUESTION => '?',
            self::SHOUT => '!',
            self::LEFT_OR_RIGHT => 'LR',
            self::X_CHAT_ACTION => 'Chat',
            self::POLL => 'Poll',
            self::EASY_POST => 'Easy Post',
            self::IMAGE => 'Image',
            self::PIGPUNKS_IMAGE => 'Image PigPunks',
            self::HASHTAG => '#',
        };
    }
}
