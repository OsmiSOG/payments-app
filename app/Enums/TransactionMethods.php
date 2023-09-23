<?php

namespace App\Enums;

enum TransactionMethods: String
{
    case Card = 'Card';
    case BankTransfer = 'Bank Transfer';
}
