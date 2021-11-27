<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SessionTrait
{
    use RequestStackTrait;

    public function getSession(): SessionInterface|null
    {
        try {
            return $this->requestStack->getSession();
        } catch (SessionNotFoundException) {
            return null;
        }
    }
}