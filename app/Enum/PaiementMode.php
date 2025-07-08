<?php

namespace App\Enum;

enum PaiementMode: string
{
    case CASH = 'cash';
    case MPESA = 'vodacome';
    case AIRTELMONEY = 'airtel';
    case ORANGEMONEY = 'orange';
    case AFRIMONEY = 'africell';
    case VISA = 'visa';

}
