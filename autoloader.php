<?php


//Use the autoloader function to automatically load classes when a new class instance is called.
spl_autoload_register(function ($classname){


    //Look through the Relevant folders for php files (Defined in $paths array)
    //Build the filepath of the file that's needed, then include that file.
    $paths = [__DIR__ . '/config/', __DIR__ . '/classes/'];

    foreach ($paths as $path){

        $file = $path . $classname . '.php';

        if(file_exists($file)){
            require_once $file;
            return;
        }
    }

});

?>