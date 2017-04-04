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

    private $size;

    public $config = array(
        'thumbnail' => 300,
        'medium' => 800,
        'large' => 1200
    );

    public function __construct(array $config = array())
    {
        $this->configure($config);
    }

    public function configure(array $config = array())
    {
        $this->config = array_replace($this->config, $config);
        return $this;
    }

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

    public function resize($size, $width = 0, $height = 0)
    {
        $this->size = $size;
        switch ($size){
            case self::THUMBNAIL:
                if ($width != 0 && $height == 0){
                    $height = $width;
                    $fixed = false;
                }else{
                    $fixed = $width != 0 && $height != 0 ? true : false;
                    $width = $width == 0 ? $this->config['thumbnail'] : $width;
                    $height = $height == 0 ? $this->config['thumbnail'] : $height;
                }
                $thumb = new Thumbnail($this->image, $this->resolution, $width, $height);
                $this->image = $thumb->createImage($fixed);
                break;
            case self::MEDIUM:
                if ($width != 0 && $height == 0){
                    $height = $width;
                    $fixed = false;
                }else{
                    $fixed = $width != 0 && $height != 0 ? true : false;
                    $width = $width == 0 ? $this->config['medium'] : $width;
                    $height = $height == 0 ? $this->config['medium'] : $height;
                }
                $medium = new Medium($this->image, $this->resolution, $width, $height);
                $this->image = $medium->createImage($fixed);
                break;
            case self::LARGE:
                if ($width != 0 && $height == 0){
                    $height = $width;
                    $fixed = false;
                }else{
                    $fixed = $width != 0 && $height != 0 ? true : false;
                    $width = $width == 0 ? $this->config['large'] : $width;
                    $height = $height == 0 ? $this->config['large'] : $height;
                }
                $large = new Large($this->image, $this->resolution, $width, $height);
                $this->image = $large->createImage($fixed);
                break;
        }
        return $this;
    }

    public function save($destination = null, $quality = null)
    {
        $destination = is_null($destination) ? $this->basePath() : $destination;
        switch ($this->size){
            case self::THUMBNAIL:
                $type = 'thumbnail_';
                break;
            case self::MEDIUM:
                $type = 'medium_';
                break;
            case self::LARGE:
                $type = 'large_';
                break;
            default:$type = '_';
        }
        $path = $destination.$type.$this->basename;
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