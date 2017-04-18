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

    public function getWidth(){
        return $this->newWidth;
    }

    public function getHeight(){
        return $this->newHeight;
    }

    abstract public function createImage();
    protected function setNewResolution($fixed){
        if ($fixed){
            $this->newWidth = (int)$this->paramWidth;
            $this->newHeight = (int)$this->paramHeight;
        }else{
            if (($this->width > $this->paramWidth*2 && $this->height > $this->paramHeight*2)
                && $this->width == $this->height){
                $this->newWidth = (int)$this->paramWidth;
                $this->newHeight = (int)$this->paramHeight;
            }else{
                if ($this->height >= $this->width){
                    $this->newHeight = (int)(($this->height * $this->paramHeight) / $this->width);
                    $this->newWidth = (int)$this->paramWidth;
                }elseif ($this->height < $this->width){
                    $this->newWidth = (int)(($this->width * $this->paramWidth) / $this->height);
                    $this->newHeight = (int)$this->paramHeight;
                }
            }
        }
        return $this;
    }
}