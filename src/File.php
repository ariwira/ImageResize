<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 3/24/17
 * Time: 9:28 AM
 */

namespace Ariwira\ImageResize;


class File
{
    public $filename;
    public $basename;
    public $extension;
    public $directory;
    public $mime;
    public $resolution;

    public function setFileInfo($path){
        $info = pathinfo($path);
        $resolution = getimagesize($path);
        $this->directory = array_key_exists('dirname',$info) ? $info['dirname'] : null;
        $this->filename = array_key_exists('filename',$info) ? $info['filename'] : null;
        $this->extension = array_key_exists('extension',$info) ? $info['extension'] : null;
        $this->basename = array_key_exists('basename',$info) ? $info['basename'] : null;
        $this->resolution = $resolution;
        if (file_exists($path) && is_file($path)) {
            $this->mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        }

        return $this;
    }

    public function fileSize(){
        $path = $this->basePath();
        if (file_exists($path) && is_file($path)) {
            return filesize($path);
        }
        return false;
    }

    protected function basePath(){
        if ($this->directory && $this->basename){
            return $this->directory.'/'.$this->basename;
        }
        return false;
    }

}