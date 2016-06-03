<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/26
 * Time: 9:37
 */
namespace App\Facades;

class ArrayToObject extends \ArrayObject{

    public static function getPath(){
        //return \Illuminate\View\Compilers\BladeCompiler::getPath();
        return \Blade::getPath();
    }

    /**
     * Set the path currently being compiled.
     *
     * @param string $path
     * @return void
     * @static
     */
    public static function setPath($path){
        \Blade::setPath($path);
    }
}