<?php

namespace App\Enums;

enum SharingStatus: string
{
    case Processing = 'processing';
    case Finished = 'finished';
    case Canceled = 'canceled';
}