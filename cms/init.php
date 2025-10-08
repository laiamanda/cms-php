<?php 
    // Autoload classes
    require_once "autoloader.php"; 

    // Start Session
    session_start();

    // Include the main config file
    require_once "config/config.php";

    // // Load database
    // require_once "classes/Database.php";

    // Include helper functions
    require_once "helpers.php";

    // Define global constants
    define("APP_NAME", "CMD PDO SYSTEM");
    define("PROJECT_DIR", "cms");
?>