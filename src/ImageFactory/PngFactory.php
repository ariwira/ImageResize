<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 11:02 AM
 */

namespace Ariwira\ImageResize\ImageFactory;


class PngFactory extends \Ariwira\ImageResize\ImageFactory\ImageFactory
{

    public function createImage($source)
    {
        $source = imagecreatefrompng($source);
        return $source;
    }
}