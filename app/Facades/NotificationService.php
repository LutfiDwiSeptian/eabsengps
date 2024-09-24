<?php

namespace App\Facades;

use App\Services\NotificationService as Service;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void sendNotificationAbsenToAllUsers(string $title, string $message, string $url)
 */
class NotificationService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Service::class;
    }
}
