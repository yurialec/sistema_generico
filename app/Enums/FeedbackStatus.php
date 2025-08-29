<?php

namespace App\Enums;

enum FeedbackStatus: string
{
    case OPEN = 'open';
    case DONE = 'done';
}