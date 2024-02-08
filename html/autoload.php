<?php
/**
 * Copyright © ...
 */

class Autoloader
{
    private const PATH = 'src/';

    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = self::PATH . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}
Autoloader::register();