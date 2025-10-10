<?php 
    require_once "init.php";

    if(isPostRequest()) {
        session_destroy();
        redirect("/cms/index.php");
        exit;
    } else {
        redirect("/cms/index.php");
        exit;
    }
?>