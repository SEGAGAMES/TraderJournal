<?php

// ��������������� ����� ��� ������� ��������� ������.
class Helper
{
    // ��������� ������� ������ ��������� � �������.
    static public function isNull(array $forCheckArray)
    {
        foreach ($forCheckArray as $item)
            if (!isset($item) || $item === '')
                return true;
        return false;
    }

    //��������� ������� �� ������� �������� � �������.
    static public function isNoOneNull(array $forCheckArray)
    {
        foreach ($forCheckArray as $item)
            if (!(!isset($item) || $item === ''))
                return true;
        return false;
    }
}