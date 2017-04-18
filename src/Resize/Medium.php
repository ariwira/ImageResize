<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 10:40 AM
 */

namespace Ariwira\ImageResize\Size;


class Medium extends \Ariwira\ImageResize\Size\AbstractResize
{
    public function __construct($image,$resolution, $width, $height)
    {
        $this->image = $image;
        $this->width = $resolution[0];
        $this->height = $resolution[1];
        $this->paramWidth = $width;
        $this->paramHeight = $height;
    }

    public function createImage($fixed = false)
    {
        $this->setNewResolution($fixed);
        $medium = imagecreatetruecolor($this->newWidth, $this->newHeight);
        $resizedImage = imagecopyresampled($medium, $this->image, 0, 0, 0, 0,
            $this->newWidth, $this->newHeight,
            $this->width, $this->height);
        if ($resizedImage){
            return $medium;
        }
        return $this;
    }
}