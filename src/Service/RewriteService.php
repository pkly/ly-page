<?php

namespace App\Service;

class RewriteService
{
    public const array REWRITE_MAP = [
        'nyaa.si' => 'nyaa.iss.one',
    ];

    public function rewrite(
        string $input
    ): string {
        foreach (self::REWRITE_MAP as $from => $to) {
            $input = str_replace($from, $to, $input);
        }

        return $input;
    }
}
