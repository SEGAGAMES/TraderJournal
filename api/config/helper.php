<?php

// Вспомогательный класс обработки данных.
class Helper
{
    // Проверка что все элементы не нулевые.
    static public function isNull(array $forCheckArray)
    {
        foreach ($forCheckArray as $item)
            if (!isset($item) || $item === '')
                return true;
        return false;
    }

    // Проверка на наличие не нулевого элемента.
    static public function isNoOneNull(array $forCheckArray)
    {
        foreach ($forCheckArray as $item)
            if (!(!isset($item) || $item === ''))
                return true;
        return false;
    }
}