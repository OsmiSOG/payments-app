<?php

namespace App\Enums;

enum TransactionNetwork: String
{
    case Visa = 'Visa';
    case Mastercard = 'Mastercard';
    case Dinners = 'Dinners Club';
    case AmericanExpress = 'American Express';
}
