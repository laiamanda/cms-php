<?php 
    require 'init.php';

    if(isPostRequest()) {
        if(isset($_POST['reorder_articles'])) {
            $article = new Article();
            try { 
                $article->reorderAndResetAutoIncrement();
                redirect('/cms/admin.php');
            } catch (Exception $e) {
                redirect('/cms/admin.php');
            }
        } else {
            echo "Failed";
        }
    }
?>