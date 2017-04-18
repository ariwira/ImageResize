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
use Carbon\Carbon;

class Image extends File
{
    const THUMBNAIL = 'thumbnail';
    const MEDIUM = 'medium';
    const LARGE = 'large';

    protected $image;
    protected $newImage;
    public $final;

    public static $factory;

    private $size;
    private $time;

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

    protected function tests($source,$path)
    {
        //1970x1012_ss6
//        $resource = imagecreatefrompng($source);
//        $resolution = getimagesize($source);
//        $thumb = imagecreatetruecolor(800, 411);
//        $resizedImage = imagecopyresampled($thumb, $resource, 0, 0, 0, 0,
//            800, 411,
//            1970, 1012);
//        imagepng($thumb, $path);

        //ss5 1500x720
        $resource = imagecreatefrompng($source);
        $resolution = getimagesize($source);
        $thumb = imagecreatetruecolor(2100, 1008);
        $resizedImage = imagecopyresampled($thumb, $resource, 0, 0, 0, 0,
            2100, 1008,
            1500, 720);
        imagepng($thumb, $path);

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

    public function resize($tempPath,$sizeThumbnail = 0, $sizeMedium = 0, $sizeLarge = 0)
    {
        $time = Carbon::now()->timestamp;
        $this->time = $time;
        //create temp dir
        $path = $this->createTempImageDir($tempPath.'/'.$time);

        //Large Size
        if ($sizeLarge != 0){
            //check if param is array(width,height)
            if (is_array($sizeLarge) && count($sizeLarge) == 2){
                $width = $sizeLarge[0];
                $height = $sizeLarge[1];
                $fixed_AspectRatio = true;
            }else{
                $width = $sizeLarge;
                $height = $sizeLarge;
                $fixed_AspectRatio = false;
            }
        }else{
            $width = $this->config['large'];
            $height = $this->config['large'];
            $fixed_AspectRatio = false;
        }
        $this->size = 'large';
        $large = new Large($this->image, $this->resolution, $width, $height);
        $this->newImage = $large->createImage($fixed_AspectRatio);
//        //save to temp directory
        $this->save($path == true ? $tempPath.'/'.$time : $tempPath);

        //medium size
        if ($sizeMedium != 0){
            //check if param is array(width,height)
            if (is_array($sizeMedium) && count($sizeMedium) == 2){
                $width = $sizeMedium[0];
                $height = $sizeMedium[1];
                $fixed_AspectRatio = true;
            }else{
                $width = $sizeMedium;
                $height = $sizeMedium;
                $fixed_AspectRatio = false;
            }
        }else{
            $width = $this->config['medium'];
            $height = $this->config['medium'];
            $fixed_AspectRatio = false;
        }
        $this->size = 'medium';
        $medium = new Medium($this->image, $this->resolution, $width, $height);
        $this->newImage = $medium->createImage($fixed_AspectRatio);
        //save to temp directory
        $this->save($path == true ? $tempPath.'/'.$time : $tempPath);

        //thumbnail
        if ($sizeThumbnail != 0){
            //check if param is array(width,height)
            if (is_array($sizeThumbnail) && count($sizeThumbnail) == 2){
                $width = $sizeThumbnail[0];
                $height = $sizeThumbnail[1];
                $fixed_AspectRatio = true;
            }else{
                $width = $sizeThumbnail;
                $height = $sizeThumbnail;
                $fixed_AspectRatio = false;
            }
        }else{
            $width = $this->config['thumbnail'];
            $height = $this->config['thumbnail'];
            $fixed_AspectRatio = false;
        }
        $this->size = 'thumbnail';
        $thumb = new Thumbnail($this->image, $this->resolution, $width, $height);
        $this->newImage = $thumb->createImage($fixed_AspectRatio);
        //save to temp directory
        $this->save($path == true ? $tempPath.'/'.$time : $tempPath);


//        if ($sizeThumbnail != 0){
//            //check if param is array(width,height)
//            if (is_array($sizeThumbnail) && count($sizeThumbnail) == 2){
//                $width = $sizeThumbnail[0];
//                $height = $sizeThumbnail[1];
//                $fixed_AspectRatio = true;
//            }else{
//                $width = $sizeThumbnail;
//                $height = $sizeThumbnail;
//                $fixed_AspectRatio = false;
//            }
//        }else{
//            $width = $this->config['thumbnail'];
//            $height = $this->config['thumbnail'];
//            $fixed_AspectRatio = false;
//        }
//        $thumb = new Thumbnail($this->image, $this->resolution, $width, $height);
//        $this->image = $thumb->createImage($fixed_AspectRatio);

//
//        $this->size = $size;
//        switch ($size){
//            case self::THUMBNAIL:
//                if ($width != 0 && $height == 0){
//                    $height = $width;
//                    $fixed = false;
//                }else{
//                    $fixed = $width != 0 && $height != 0 ? true : false;
//                    $width = $width == 0 ? $this->config['thumbnail'] : $width;
//                    $height = $height == 0 ? $this->config['thumbnail'] : $height;
//                }
//                $thumb = new Thumbnail($this->image, $this->resolution, $width, $height);
//                $this->image = $thumb->createImage($fixed);
//                break;
//            case self::MEDIUM:
//                if ($width != 0 && $height == 0){
//                    $height = $width;
//                    $fixed = false;
//                }else{
//                    $fixed = $width != 0 && $height != 0 ? true : false;
//                    $width = $width == 0 ? $this->config['medium'] : $width;
//                    $height = $height == 0 ? $this->config['medium'] : $height;
//                }
//                $medium = new Medium($this->image, $this->resolution, $width, $height);
//                $this->image = $medium->createImage($fixed);
//                break;
//            case self::LARGE:
//                if ($width != 0 && $height == 0){
//                    $height = $width;
//                    $fixed = false;
//                }else{
//                    $fixed = $width != 0 && $height != 0 ? true : false;
//                    $width = $width == 0 ? $this->config['large'] : $width;
//                    $height = $height == 0 ? $this->config['large'] : $height;
//                }
//                $large = new Large($this->image, $this->resolution, $width, $height);
//                $this->image = $large->createImage($fixed);
//                break;
//            case 'all':
//                //create all size and zip it
//                if ($width != 0 && $height == 0){
//                    $height = $width;
//                    $fixed = false;
//                }else{
//                    $fixed = $width != 0 && $height != 0 ? true : false;
//                    $width = $width == 0 ? $this->config['large'] : $width;
//                    $height = $height == 0 ? $this->config['large'] : $height;
//                }
//                $large = new Large($this->image, $this->resolution, $width, $height);
//                $this->image = $large->createImage($fixed);
//                break;
//        }
        return $this;
    }

    public function zip($destination){
        return realpath($this->zipDir($destination,$this->time));
    }

    protected function save($destination = null, $quality = null)
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
        $path = $destination.'/'.$type.$this->basename;
        $data = $this->newImage;
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
        $this->final = $path;
        return $this;
    }

}