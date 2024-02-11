<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Service\Attribute\Required;

trait RequestStackTrait
{
    protected RequestStack $requestStack;

    #[Required]
    public function setRequestStack(
        RequestStack $requestStack
    ): void {
        $this->requestStack = $requestStack;
    }
}
