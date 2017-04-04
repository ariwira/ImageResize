<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 10:37 AM
 */

namespace Ariwira\ImageResize\Size;


abstract class AbstractResize
{
    //current file resolution
    protected $width;
    protected $height;
    protected $image;
    //param width and height
    protected $paramHeight;
    protected $paramWidth;
    //new resolusion
    protected $newWidth;
    protected $newHeight;

    abstract public function createImage();
    protected function setNewResolution($fixed){
        if ($fixed){
            $this->newWidth = $this->paramWidth;
            $this->newHeight = $this->paramHeight;
        }else{
            if (($this->width > $this->paramWidth*2 && $this->height > $this->paramHeight*2)
                && $this->width == $this->height){
                $this->newWidth = $this->paramWidth;
                $this->newHeight = $this->paramHeight;
            }else{
                if ($this->height >= $this->width){
                    $this->newHeight = ($this->height * $this->paramHeight) / $this->width;
                    $this->newWidth = $this->paramWidth;
                }elseif ($this->height < $this->width){
                    $this->newWidth = ($this->width * $this->paramWidth) / $this->height;
                    $this->newHeight = $this->paramHeight;
                }
            }
        }
        return $this;
    }
}