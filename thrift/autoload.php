<?php
function thrift_autoload($class_name)   {
    $directory_array = Array('protocol', 'transport');
    foreach ($directory_array as $dir)  {
        $file = $GLOBALS['THRIFT_ROOT'] . '/' . $dir . '/' . $class_name . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
}

spl_autoload_register('thrift_autoload');