<?php

declare(strict_types=1);

namespace App\Enum;

enum SocialMediaEnum: string
{
    case FACEBOOK = 'facebook.com';
    case INSTAGRAM = 'instagram.com';
    case LINKEDIN = 'linkedin.com';
    case PINTEREST = 'pinterest.com';
    case SPOTIFY = 'spotify.com';
    case X = 'x.com';
    case VIMEO = 'vimeo.com';
    case YOUTUBE = 'youtube.com';
    case TIKTOK = 'tiktok.com';

    public function getParsingRegex(): string
    {
        return match ($this) {
            self::FACEBOOK, self::INSTAGRAM, self::PINTEREST, self::VIMEO => "/(?:{$this->value}\/(?:profile\.php\?id=)?|^)([\w\d\.]+)$/i",

            self::X, self::YOUTUBE, self::TIKTOK => "/(?:{$this->value}\/|^)(@?[\w\d\.]+)$/i",

            self::LINKEDIN => "/(?:{$this->value}\/in\/|^)([\w\d-]+)$/i",

            self::SPOTIFY => "/(?:open\.)?spotify\.com\/(?:intl-\w+\/)?(?:(user|artist)\/([\w\d]+))|^(user|artist)\/([\w\d]+)$/i",
        };
    }
}
