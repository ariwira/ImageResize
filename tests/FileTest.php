<?php
/**
 *  Corresponding Class to test YourClass class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 *  @author yourname
 */

use Ariwira\ImageResize\File;

class FileTest extends \PHPUnit\Framework\TestCase{

    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testIsThereAnySyntaxError(){
        $var = new File;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testMethod1(){
        $var = new File;
        $result = $var->setFileInfo('/Users/selamet/DockerEnv/TestPackage/tests/img/default.jpg');
        $size = $var->fileSize();
        var_dump($result, $size);
        $this->assertInstanceOf(File::class, $result);
        unset($var);
    }

}