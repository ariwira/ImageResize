<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 11:00 AM
 */

namespace Ariwira\ImageResize\ImageFactory;


abstract class ImageFactory
{
    abstract protected function createImage($source);

    public function create($source)
    {
        $obj = $this->createImage($source);

        return $obj;
    }
}