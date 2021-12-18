<?php

namespace App\Enum;

enum SessionOptions: string
{
    case MASCOT_GROUP = 'mascot_group';
    case MASCOT_COUNTER = 'mascot_counter';
    case LAST_MASCOT_UPDATE = 'last_mascot_update';
}
