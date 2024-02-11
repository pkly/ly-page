<?php

namespace App\Twig;

use Symfony\Component\Finder\Finder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_vue_entrypoint', $this->vueEntrypoint(...))
        ];
    }

    private function vueEntrypoint(): string|null
    {
        $filename = null;

        foreach ((new Finder())->in(__DIR__.'/../../public/vue/assets')->name('main-*.js')->files() as $file) {
            $pos = strpos($path = $file->getRealPath(), 'public/vue/assets');
            $filename = substr($path, $pos + 7);
        }

        return $filename;
    }
}