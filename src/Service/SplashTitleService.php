<?php

namespace App\Service;

class SplashTitleService
{
    private const TITLES = [
        '頑張ってねライちゃん！',
        'おはよう',
    ];

    public function getTitle(): string
    {
        return self::TITLES[array_rand(self::TITLES)];
    }
}
