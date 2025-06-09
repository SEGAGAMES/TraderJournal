<?php

// Вспомогательный класс для удобной обработки данных.
class Helper
{
    // Проверяет наличие пустых элементов в массиве.
    static public function isNull(array $forCheckArray)
    {
        foreach ($forCheckArray as $item)
            if (!isset($item) || $item === '')
                return true;
        return false;
    }

    //Проверяет наличие не пустого элемента в массиве.
    static public function isNoOneNull(array $forCheckArray)
    {
        foreach ($forCheckArray as $item)
            if (!(!isset($item) || $item === ''))
                return true;
        return false;
    }
}