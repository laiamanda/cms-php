<?php 
    // Retrieves the base url of the application
    function base_url($path=""){
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off" ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];

        $baseUrl = $protocol . $host . '/' . PROJECT_DIR;
        return $baseUrl . '/' . ltrim($path,'/');
    }

    // Get base path
    function base_path($path="") {
        $rootPath = dirName(__DIR__) . DIRECTORY_SEPARATOR . PROJECT_DIR;
        return $rootPath . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    }

    // Get the uploads path
    function uploads_path($filename='') {
        return base_path('uploads'. DIRECTORY_SEPARATOR . $filename);
    }

    // Get uploads url
    function uploads_url($filename='') {
        return base_path('uploads/'. ltrim($filename, '/'));
    }
    // Get asset url
    function asset_url($path="") {
        return base_url('assets/') . ltrim($path, '/');
    }

    // Redirect URL
    function redirect($url) {
        header("Location: " . base_url($url));
        exit;
    }

    // Check if it is a post request
    function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }

    // Retrieves the Post Data
    function getPostData($field, $default=null) {
        // Returns if isset trim it else it will return the default
        return isset($_POST[$field]) ? trim($_POST[$field]) : $default;
    }

    // Format a Date
    function formatDate($date) {
        return date('F j, Y', strtotime($date));
    }

    // See if the user is logged in - used for navbar
    function isLoggedIn() {
        if(isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
        
    }

    // Check if the user is logged in 
    function checkUserLoggedIn() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        } 

        if(!isset($_SESSION['user_id'])) {
            redirect('/cms/login.php');
        }
    }


    
?>