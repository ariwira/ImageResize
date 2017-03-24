<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 11:00 AM
 */

namespace Ariwira\ImageResize\ImageFactory;


class JpegFactory extends ImageFactory
{

    public function createImage($source)
    {
        $source = imagecreatefromjpeg($source);
        return $source;
    }
}