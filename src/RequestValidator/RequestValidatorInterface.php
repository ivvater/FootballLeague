<?php

namespace App\RequestValidator;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface
{
    public function validate(Request $request): void;
}
