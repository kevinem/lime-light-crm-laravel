<?php


namespace KevinEm\LimeLightCRMLaravel\Facades;


use Illuminate\Support\Facades\Facade;

class LimeLightCRMLaravel extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'lime-light-crm-laravel';
    }
}