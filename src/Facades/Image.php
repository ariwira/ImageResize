<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 4/4/17
 * Time: 2:44 PM
 */

namespace Ariwira\ImageResize\Facades;
use Illuminate\Support\Facades\Facade;

class Image extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'image';
    }
}