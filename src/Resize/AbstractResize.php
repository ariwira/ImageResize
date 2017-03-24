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
    abstract public function createImage();
    abstract protected function setNewResolution();
}