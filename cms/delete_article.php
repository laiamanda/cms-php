<?php 
    require_once "init.php";

    // Check if the user is logged in
    checkUserLoggedIn();


    // Check if it's a post request
    if(isPostRequest()) {
        $id = $_POST['id'];
        $article = new Article();

        if($article->deleteWithImage($id)){
            redirect("/cms/admin.php");
        } else {
            echo "Failed to delete";
        }
    }
?>