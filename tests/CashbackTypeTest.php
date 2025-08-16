<?php

use Sashalenz\MonobankApi\Enums\CashbackType;

it('contains expected cashback types', function () {
    $values = array_map(fn (CashbackType $case) => $case->value, CashbackType::cases());

    expect($values)->toBe([
        'None',
        'UAH',
        'Miles',
    ]);
});
