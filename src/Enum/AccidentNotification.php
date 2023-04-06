<?php

declare(strict_types=1);

namespace App\Enum;

enum AccidentNotification: string
{
    case DEADLINE = 'termin';
    case NEW = 'nowy';
}
