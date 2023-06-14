<?php

declare(strict_types=1);

namespace Exception;

class ParameterException extends \Exception
{
    /**
     * Retourne une représentation sous forme de chaîne de caractères de l'exception.
     *
     * @return string Une chaîne de caractères représentant l'exception.
     */
    public function __toString(): string
    {
        return __CLASS__ . ": ParameterException";
    }
}
