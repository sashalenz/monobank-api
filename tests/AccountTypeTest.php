<?php

use Sashalenz\MonobankApi\Enums\AccountType;

it('contains expected account types', function () {
    $values = array_map(fn (AccountType $case) => $case->value, AccountType::cases());

    expect($values)->toBe([
        'black',
        'white',
        'platinum',
        'iron',
        'fop',
        'yellow',
    ]);
});

