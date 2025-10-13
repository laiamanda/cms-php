<?php 
    include "partials/admin/header.php";
    include "partials/admin/navbar.php";

    $article = new Article();

    $userId = $_SESSION['user_id'];
    $userArticles = $article->getArticlesByUser($userId);
?>
    

    <!-- Main Content -->
    <main class="container my-5">
    <h2 class="mb-4"> Welcome <?php echo $_SESSION['username']; ?> to your Admin Dashboard</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="d-flex align-items-center" action="<?php echo base_url('cms/create-dummy-articles.php'); ?>" method="post">
            <label class="form-label me-2" for="articleCount"> Number of Articles</label>
            <input id="articleCount" min="1" style="width:100px" class="form-control me-2" name="article_count" type="number">
            <button id="articleCount" class="btn btn-primary" type="submit">Generate Articles</button>
        </form>

        <form action="<?php echo base_url('cms/reorder-articles.php'); ?>" method="post">
            <button name="reorder_articles" class="btn btn-warning" type="submit">Reorder Articles ID's</button>
        </form>

        <button id="deleteSelectedBtn" class="btn btn-danger">Delete Selected Articles</button>
    </div>

    <!-- Articles Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Excerpt</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Ajax Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($userArticles)): ?>
                    <?php foreach($userArticles as $articleItem): ?>
                        <!-- Article Row -->
                        <tr>
                            <td><input type="checkbox" class="articleCheckbox" value="<?php echo $articleItem->id; ?>"></td>
                            <td><?php echo $articleItem->id ?></td>
                            <td><?php echo $articleItem->title ?></td>
                            <td><?php echo $_SESSION['username']; ?></td>
                            <td><?php echo $article->formatCreatedAt($articleItem->created_at); ?></td>
                            <td>
                                <?php echo ($articleItem->content); // $article->getExcerpt($articleItem->content);??? ?>
                            </td>
                            <td>
                                <a href="edit-article.php?id=<?php echo $articleItem->id; ?>" class="btn btn-sm btn-primary me-1">Edit</a>
                            </td>
                            <td>
                                <form onsubmit="confirmDelete(<?php echo $articleItem->id;?>)"method="POST" action="<?php echo base_url("/cms/delete_article.php")?>">
                                    <input name="id" value="<?php echo $articleItem->id;?>" type="hidden">
                                    <!-- <button class="btn btn-sm btn-danger">Delete</button> -->
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                            <td><button data-id="<?php echo $articleItem->id; ?>" class="btn btn-sm btn-danger delete-single">ajax delete</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    // Select or Deselect all checkboxes
    document.getElementById('selectAll').onclick = function(){
        let checkboxes = document.querySelectorAll('.articleCheckbox');
        for(let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };

    // When the user clicks on the delete selected btn
    // Push it to the selectedIds Array
    document.getElementById('deleteSelectedBtn').onclick = function(){
        let selectedIds = [];
        let checkboxes = document.querySelectorAll('.articleCheckbox:checked');

        checkboxes.forEach((checkbox) => {
            selectedIds.push(checkbox.value);
        });

        // Check if something is selected
        if(selectedIds.length === 0) {
            alert('Select at least one');
            return;
        }

        // Confirm the user to delete
        if(confirm("Are you sure you want to delete this article(s)")) {
            sendDeleteRequest(selectedIds);
        }
    }

    // Delete Singular Checkbox
    document.querySelectorAll('.delete-single').forEach((button) => {
        button.onclick= function() {
            let articleId = this.getAttribute('data-id');

            if(confirm("Are you sure you want to delete this article: " + articleId + "?")) {
                sendDeleteRequest([articleId]);
            }
        }
    });

    // Delete Request using Ajax
    function sendDeleteRequest(articleIds) {
        let xhr = new XMLHttpRequest();

        xhr.open('POST','<?php echo base_url('/cms/delete-articles.php') ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if(response.success) {
                    alert("Article was successfully deleted");
                    location.reload();
                } else {
                    alert("Failed: " + response.message);
                }
            }
        };

        xhr.send(JSON.stringify({article_ids: articleIds}));
        
    }
</script>

<?php 
    include "partials/admin/footer.php";
?>