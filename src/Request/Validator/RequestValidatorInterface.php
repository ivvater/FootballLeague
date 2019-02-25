<?php

declare(strict_types=1);

namespace App\Request\Validator;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface
{
    public function validate(Request $request): void;
}
