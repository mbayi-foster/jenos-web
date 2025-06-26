<?php

namespace App\Enum;

enum UserType: string
{
    case CLIENT = "client";
    case ADMIN = "admin";
    case Livreur = "livreur";
}
