<?php
/**
 * Created by PhpStorm.
 * User: wira
 * Date: 3/16/17
 * Time: 5:41 PM
 */
//Image Client Class

namespace Ariwira\ImageResize;

use Ariwira\ImageResize\ImageFactory\GifFactory;
use Ariwira\ImageResize\ImageFactory\JpegFactory;
use Ariwira\ImageResize\ImageFactory\PngFactory;
use Ariwira\ImageResize\Size\Large;
use Ariwira\ImageResize\Size\Medium;
use Ariwira\ImageResize\Size\Thumbnail;

class Image extends File
{
    const THUMBNAIL = 'thumbnail';
    const MEDIUM = 'medium';
    const LARGE = 'large';

    protected $image;

    public static $factory;

    public function create($source)
    {
        $this->setFileInfo($source);
        switch ($this->mime){
            case 'image/jpeg':
                self::$factory = new JpegFactory();
                $this->image = self::$factory->createImage($source);
                break;

            case 'image/png':
                self::$factory = new PngFactory();
                $this->image = self::$factory->createImage($source);
                break;

            case 'image/gif':
                self::$factory = new GifFactory();
                $this->image = self::$factory->createImage($source);
                break;

            default:
                return false;
        }
        return $this;
    }

    public function resize($size)
    {
        switch ($size){
            case self::THUMBNAIL:
                $thumb = new Thumbnail($this->image, $this->resolution);
                $this->image = $thumb->createImage();
                break;
            case self::MEDIUM:
                $thumb = new Medium($this->image, $this->resolution);
                $this->image = $thumb->createImage();
                break;
            case self::LARGE:
                $thumb = new Large($this->image, $this->resolution);
                $this->image = $thumb->createImage();
                break;
        }
        return $this;
    }

    public function save($destination = null, $quality = null)
    {
        $destination = is_null($destination) ? $this->basePath() : $destination;
        $path = $destination.$this->basename;
        $data = $this->image;
        switch ($this->mime){
            case 'image/jpeg':
                imagejpeg($data, $path);
                break;
            case 'image/png':
                imagepng($data, $path);
                break;
            case 'image/gif':
                imagegif($data, $path);
                break;
            default:
                return false;
        }
        return $this;
    }

}