<?php

use App\Enums\TransactionNetwork;
use App\Enums\TransactionStatus;

return [
    [
        'card_network' => TransactionNetwork::Mastercard->value,
        'number' => '5249 3140 2334 0339',
        'number_2' => '5249314023340339',
        'cvv' => '478',
        'status' => TransactionStatus::Approved->value,
        'icon' => 'fa-brands fa-cc-mastercard',
    ],
    [
        'card_network' => TransactionNetwork::Mastercard->value,
        'number' => '5163 8852 8716 0861',
        'number_2' => '5163885287160861',
        'cvv' => '705',
        'status' => TransactionStatus::Rejected->value,
        'icon' => 'fa-brands fa-cc-mastercard',
    ],
    [
        'card_network' => TransactionNetwork::Visa->value,
        'number' => '4485 9021 7887 7927',
        'number_2' => '4485902178877927',
        'cvv' => '963',
        'status' => TransactionStatus::Approved->value,
        'icon' => 'fa-brands fa-cc-visa',
    ],
    [
        'card_network' => TransactionNetwork::Visa->value,
        'number' => '4315 8923 8199 8017',
        'number_2' => '4315892381998017',
        'cvv' => '950',
        'status' => TransactionStatus::Rejected->value,
        'icon' => 'fa-brands fa-cc-visa',
    ],
    [
        'card_network' => TransactionNetwork::AmericanExpress->value,
        'number' => '3402 564352 97046',
        'number_2' => '340256435297046',
        'cvv' => '4405',
        'status' => TransactionStatus::Approved->value,
        'icon' => 'fa-brands fa-cc-amex',
    ],
    [
        'card_network' => TransactionNetwork::AmericanExpress->value,
        'number' => '3723 190710 51332',
        'number_2' => '372319071051332',
        'cvv' => '7048',
        'status' => TransactionStatus::Rejected->value,
        'icon' => 'fa-brands fa-cc-amex',
    ],
    [
        'card_network' => TransactionNetwork::Dinners->value,
        'number' => '3013 190041 2377',
        'number_2' => '30131900412377',
        'cvv' => '870',
        'status' => TransactionStatus::Approved->value,
        'icon' => 'fa-brands fa-cc-diners-club',
    ],
    [
        'card_network' => TransactionNetwork::Dinners->value,
        'number' => '3000 614052 3128',
        'number_2' => '30006140523128',
        'cvv' => '725',
        'status' => TransactionStatus::Rejected->value,
        'icon' => 'fa-brands fa-cc-diners-club',
    ],
];
