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
    protected $storagePath;

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

    protected function createTempImageDir($pathname){
        $this->storagePath = $pathname;
        return mkdir($pathname,0777,true);
    }

    protected function zipDir($pathname, $dirname){
        // Get real path for our folder
        $rootPath = realpath($this->storagePath);
        $publicpath = realpath($pathname);
        $savePath = $publicpath.'/'.$dirname.'.zip';
        // Initialize archive object
        $zip = new \ZipArchive();
        $zip->open($savePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

//        return $source;
        $iterator = new \RecursiveDirectoryIterator($rootPath);
        // skip dot files while iterating
        $iterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);

//
//        // Create recursive directory iterator
//        $files =
//            new \RecursiveDirectoryIterator(
//                new \RecursiveDirectoryIterator($rootPath),
//                \RecursiveIteratorIterator::LEAVES_ONLY
//            );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        // Zip archive will be created only after closing object
        $zip->close();
        return $savePath;
    }

}