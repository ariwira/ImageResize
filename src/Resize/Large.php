<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 10:41 AM
 */

namespace Ariwira\ImageResize\Size;


class Large extends \Ariwira\ImageResize\Size\AbstractResize
{
    protected $width;
    protected $height;

    protected $image;

    private $newWidth;
    private $newHeight;


    public function __construct($image,$resolution)
    {
        $this->image = $image;
        $this->width = $resolution[0];
        $this->height = $resolution[1];
    }

    public function createImage()
    {
        $this->setNewResolution();
        $thumb = imagecreatetruecolor($this->newWidth, $this->newHeight);
        $resizedImage = imagecopyresampled($thumb, $this->image, 0, 0, 0, 0, $this->newWidth, $this->newHeight,
            $this->width, $this->height);
        if ($resizedImage){
            return $thumb;
        }
    }

    protected function setNewResolution()
    {
        if (($this->width > 2400 || $this->height > 2400) && $this->width == $this->height){

            $this->newWidth = $this->width/2;
            $this->newHeight = $this->height/2;

        }else{
            if ($this->height >= $this->width){
                $this->newHeight = ($this->height * 1200) / $this->width;
                $this->newWidth = 1200;
            }elseif ($this->height < $this->width){
                $this->newWidth = ($this->width * 1200) / $this->height;
                $this->newHeight = 1200;
            }
        }
        return $this;
    }
}