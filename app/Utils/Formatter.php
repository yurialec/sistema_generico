<?php

namespace App\Utils;

class Formatter
{
    /**
     * Retorna somente números inteiros de uma string, preservando zeros à esquerda.
     *
     * @param string $value
     * @return string
     */
    public static function onlyNumbers(string $value): string
    {
        return preg_replace('/\D/', '', $value) ?? '';
    }
}