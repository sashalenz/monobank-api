<?php

namespace Sashalenz\MonobankApi\Enums;

enum AccountType: string
{
    case BLACK = 'black';
    case WHITE = 'white';
    case PLATINUM = 'platinum';
    case IRON = 'iron';
    case FOP = 'fop';
    case YELLOW = 'yellow';
    case EAID = 'eAid';
    case MADE_IN_UKRAINE = 'madeInUkraine';
}
