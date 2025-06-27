<?php

namespace App\Enum;

enum UserStatus :string
{
    case ACTIVE = "active";
    case INACTIVE = "inactive";
    case DELETED = "deleted";
    
}
