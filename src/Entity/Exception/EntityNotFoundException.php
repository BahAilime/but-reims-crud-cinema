<?php

declare(strict_types=1);

namespace Entity\Exception;

class EntityNotFoundException extends \OutOfBoundsException
{
    public function __toString(): string
    {
        return __CLASS__ . ": no data can be found";
    }
}
