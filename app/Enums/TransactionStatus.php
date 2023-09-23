<?php

namespace App\Enums;

enum TransactionStatus: String
{
    case Init = 'Init';
    case Pending = 'Pending';
    case Approved = 'Approved';
    case Rejected = 'Rejected';
    case Failed = 'Failed';
}
