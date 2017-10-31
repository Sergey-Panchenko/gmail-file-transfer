<?php

namespace App\Facades;

use App\Services\GmailService;
use Illuminate\Support\Facades\Facade;

class GmailFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GmailService::class;
    }
}