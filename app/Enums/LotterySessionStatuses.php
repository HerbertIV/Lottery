<?php

namespace App\Enums;

enum LotterySessionStatuses: string
{
    use EnumToArray;

    case ACTIVE = 'active';
    case UN_ACTIVE = 'un_active';
}
