<?php 
    require 'init.php';

    if(isPostRequest()) {
        $article = new Article();

        if($article->generateDummyData($_POST['article_count'])) {
            redirect('/cms/admin.php');
        } else {
            echo "Failed";
        }
    }
?>