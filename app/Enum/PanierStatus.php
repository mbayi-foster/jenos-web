<?php

namespace App\Enum;

enum PanierStatus: string
{
    case AVAILLABLE = 'available';
    case COMMANDED = 'commanded';
    case DELETED = 'deleted';
}
