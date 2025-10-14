<?php 
    // Autoload classes
    spl_autoload_register(function($class_name) {
        $directory = __DIR__ . "/classes/";
        $file = $directory . $class_name . ".php";
        // Check if the file exists
        if(file_exists($file)) {
            require_once $file;
        } else {
            // Kill the application if unable to find file
            die("Class file for {$class_name} not found in {$file}");
        }
    });
?>