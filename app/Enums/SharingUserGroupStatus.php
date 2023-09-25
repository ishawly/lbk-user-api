<?php

namespace App\Enums;

enum SharingUserGroupStatus: string
{
    case Processing = 'processing';
    case Finished   = 'finished';
    case Canceled   = 'canceled';
}
