<?php

namespace core\Enums;

class ETypeConcept
{
    CONST DEVENGO = 'devengo';
    CONST DEDUCCION = 'deduccion';

    /**
     * Valida si el valor dado es un valor válido para el "enum".
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        return in_array($value, [self::DEVENGO, self::DEDUCCION], true);
    }
}
