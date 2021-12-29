<?php
require_once 'inc/header.php';
// global $slug;

if (isset($_GET['category'])) {
    $slug = $_GET['category'];
    $article = Post::articleByCategory($slug);
} elseif (isset($_GET['language'])) {
    $slug = $_GET['language'];
    $article = Post::articleByLanguage($slug);
} elseif (isset($_GET['search'])) {
    $search = $_GET['search'];
    $article = Post::search($search);
} elseif (isset($_GET['delete'])) {
    $slug = $_GET['slug'];
    $del = Post::delete($slug);
    $article =  Post::all();
} elseif (isset($_GET['arti_user'])) {
    $article = Post::byUser();
} else {
    $article =  Post::all();
}


?>
                                <div class="card card-dark my-2">
                                        <div class="card-body">
                                                <a href="<?= $article['prev_page'] ?>" class="btn btn-danger"> Prev Posts</a>
                                                <a href="<?= $article['next_page'] ?>" class="btn btn-danger float-right">Next Posts</a>
                                        </div>
                                </div>
                                <?php if (isset($_GET['delete']) && $del): ?>
                                <div class="alert alert-danger">
                                        Deleted Successfully!
                                </div>
                                <?php endif; ?>
                                <div class="card card-dark">
                                        <div class="card-body">
                                                <div class="row">
                                                        <!-- Loop this -->
                                                        <?php
                                                        
                                                        foreach ($article['data'] as $a):
                                                               
                                                         ?>

 <div class="col-md-4" style="display:flex;">
<div class="card" style="width: 18rem;">
<img class="card-img-top" src="<?= $a->image ?>" alt="Card image cap">
                                                                        <div class="card-body">
                                                                                <h5 class="text-dark"><?= $a->title ?></h5>
                                                                        </div>
                                                                       
                                                                        <div class="card-footer">
                                                                                <div class="row">
                                                                                        <div
                                                                                                class="col-md-2 text-center mr-4">
                                                                                                <i
                                                                                                        class="fas fa-heart text-warning" id="like" user_id="<?=  $user_id = User::auth() ? User::auth()->id : 0;?>" article_id="<?= $a->id ?>">
                                                                                                </i>
                                                                                                <small
                                                                                                        class="text-muted" id="like_count"><?= $a->like_count ?></small>
                                                                                        </div>
                                                                                        <div
                                                                                                class="col-md-2 text-center mr-4">
                                                                                                <a href="<?= 'detail.php?slug='.$a->slug ?>"><i
                                                                                                        class="far fa-comment text-dark"></i></a>
                                                                                                <small
                                                                                                        class="text-muted"><?= $a->comment_count ?></small>
                                                                                        </div>
                                                                                        <div
                                                                                                class="col-md-2 text-center">
                                                                                                <a href="<?= 'detail.php?slug='.$a->slug ?>"
                                                                                                        class="badge badge-warning p-1"><i></i> View</a>
                                                                                        </div>
                                                                                        <?php
                                                                                        
                                                                                        
                                                                                        if (User::auth() && $a->user_id == User::auth()->id): ?>
                                                                                        <div class="col-md-1">
                                                                                                <a href="editArticle.php?slug=<?= $a->slug ?>"><i class="far fa-edit text-info"></i></a>

                                                                                        </div>
                                                                                        <div class="col-md-1">
                                                                                        <a href="index.php?delete&slug=<?= $a->slug ?>" id="delete"><i class="far fa-trash-alt text-danger" ></i></a>

                                                                                        </div>
                                                                                        <?php  endif; ?>
                                                                                </div>

                                                                        </div>
                                                                </div>
                                                        </div> 
                                                      
                                                       
                                                        
                                                        
                                                        

                                                       
                                                        <?php endforeach ?>     
                                                        
                                                </div>
                                        </div>
                                </div>
                               
<?php
require_once 'inc/footer.php';
?>                    
<!-- <script>
        var del = document.getElementById('delete');
        del.addEventListener('click',function(e){
                e.preventDefault();
                toastr.warning("Post deleted");
        });     
</script> -->

<script>
        var like = document.getElementById('like');
        var like_count = document.getElementById('like_count');
        like.addEventListener('click',function(e){
                e.preventDefault();
                var user_id = like.getAttribute("user_id");
                var article_id = this.getAttribute('article_id');
                if(user_id == 0)
                {
                        location.href = "login.php";
                }
                axios.get(`api.php?like&user_id=${user_id}&article_id=${article_id}`)
                .then(function(res)
                {
                        console.log(res.data);
                        
                        if(Number.isInteger(res.data))
                        {
                               
                                like_count.innerHTML = res.data;
                                toastr.success = "Like succeed";
                        }else
                        {
                                toastr.success = "liked";
                        }
                });
        });
</script>