<?php

namespace App\Enum;

enum UserStatus :string
{
    case ACTIVE = "active";
    case INACTIVE = "incative";
    case DELETED = "deleted";
    
}
