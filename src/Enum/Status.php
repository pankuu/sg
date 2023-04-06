<?php

namespace App\Enum;

enum Status: string
{
    case SCHEDULED = 'zaplanowano';
    case NEW = 'nowy';
}
