<?php

declare(strict_types=1);

namespace Exception;

class ParameterException extends \Exception
{
    public function __toString(): string
    {
        return __CLASS__ . ": ParameterException";
    }
}
