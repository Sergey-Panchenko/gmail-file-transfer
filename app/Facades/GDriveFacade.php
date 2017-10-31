<?php

namespace App\Facades;

use App\Services\GDriveService;
use Illuminate\Support\Facades\Facade;

class GDriveFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GDriveService::class;
    }
}