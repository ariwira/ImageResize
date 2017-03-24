<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 11:03 AM
 */

namespace Ariwira\ImageResize\ImageFactory;


class GifFactory extends \Ariwira\ImageResize\ImageFactory\ImageFactory
{

    public function createImage($source)
    {
        $source = imagecreatefromgif($source);
        return $source;
    }
}