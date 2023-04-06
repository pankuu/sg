<?php

namespace App\Enum;

enum Priority: string
{
    case CRITICAL = 'krytyczny';
    case HIGH = 'wysoki';
    case NORMAL = 'normalny';
}
