<?php

$loans = [
    [
        'NAME' => 'Home Loan',
        'ACTIVE' => 1,
        'DELETED' => 0
    ],
    [
        'NAME' => 'Personal Loan',
        'ACTIVE' => 1,
        'DELETED' => 0
    ],
    [
        'NAME' => 'Vehicle Loan',
        'ACTIVE' => 1,
        'DELETED' => 0
    ],
    [
        'NAME' => 'Gold Loan',
        'ACTIVE' => 1,
        'DELETED' => 0
    ]
];

$interests = [
    'Home Loan' => [
        'INTEREST_RATE' => '8'
    ],
    'Personal Loan' => [
        'INTEREST_RATE' => '13'
    ],
    'Vehicle Loan' => [
        'INTEREST_RATE' => '16'
    ],
    'Gold Loan' => [
        'INTEREST_RATE' => '2'
    ]
];

$emi = [3, 6, 9, 12, 24, 36];

return [
    'loans'         => $loans,
    'interests'     => $interests,
    'emi'           => $emi
];