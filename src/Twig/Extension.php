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
            new TwigFunction('get_vue_entrypoint', $this->vueEntrypoint(...)),
            new TwigFunction('get_vue_styles', $this->vueStyles(...)),
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

    /**
     * @return list<string>
     */
    private function vueStyles(): array
    {
        $files = [];

        foreach ((new Finder())->in(__DIR__.'/../../public/vue/assets')->name('*.css')->files() as $file) {
            $pos = strpos($path = $file->getRealPath(), 'public/vue/assets');
            $files[] = substr($path, $pos + 7);
        }

        return $files;
    }
}