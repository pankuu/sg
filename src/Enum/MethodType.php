<?php

namespace App\Enum;

enum MethodType: string
{
    case ACCIDENT_NOTIFICATION = 'zgłoszenie awarii';
    case INSPECTION = 'przegląd';
}
