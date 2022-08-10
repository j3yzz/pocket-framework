<?php


namespace Pocket;


abstract class Facade
{
    abstract public function setAccessProvider();

    public static function __callStatic(string $name, array $arguments)
    {
        var_dump($name, $arguments);
    }
}