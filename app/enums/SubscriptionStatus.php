<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case TRIAL = 'trial';
    case ISOLIR = 'isolir';
    case DISMANTLE = 'dismantle';
}