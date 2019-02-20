<?php

declare(strict_types=1);

namespace App\RequestValidator;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface
{
    public function validate(Request $request): void;
}
