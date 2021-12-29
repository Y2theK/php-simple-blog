<?php
require_once 'inc/header.php';
if(isset($_GET['slug']))
{
        $slug = $_GET['slug'];
        $article = Post::detail($slug);
       
        
}else{
        Helper::redirect('404.php');
}

?>
  <div class="card card-dark">
                                        <div class="card-body">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="card card-dark">
                                                                        <div class="card-body">
                                                                                <div class="row">
                                                                                        <!-- icons -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div
                                                                                                                class="col-md-4 text-center">
                                                                                                                <?php 
                                                                                                                $user_id = User::auth() ? User::auth()->id : 0;
                                                                                                                
                                                                                                                $article_id = $article->id;
                                                                                                                ?>
                                                                                                                <i
                                                                                                                        class="fas fa-heart text-warning" id="like" user_id=<?= $user_id ?> article_id = <?= $article_id ?>>
                                                                                                                </i>
                                                                                                                <small
                                                                                                                        class="text-muted" id="like_Count"><?= $article->like_count ?></small>
                                                                                                        </div>
                                                                                                        <div
                                                                                                                class="col-md-4 text-center">
                                                                                                                <i
                                                                                                                        class="far fa-comment text-dark"></i>
                                                                                                                <small
                                                                                                                        class="text-muted"><?= $article->comment_count; ?></small>
                                                                                                        </div>

                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- Icons -->

                                                                                        <!-- Category -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div
                                                                                                                class="col-md-12">
                                                                                                                <a href="index.php?category=<?= $article->category->slug ?>"
                                                                                                                        class="badge badge-primary"><?= $article->category->name ?>
                                                                                                                        </a>

                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- Category -->


                                                                                        <!-- language -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">

                                                                                                        <div
                                                                                                                class="col-md-12">
                                                                                                                <?php
                                                                                                                foreach($article->languages as $al) :

                                                                                                                ?>
                                                                                                                <a href="index.php?language=<?= $al->slug ?>"
                                                                                                                        class="badge badge-success"><?= $al->name ?>
                                                                                                                </a>
                                                                                                               <?php endforeach; ?>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- language -->

                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                        <h3><?= $article->title ?></h3>
                                                        <p>
                                                        <?= $article->description ?>
                                                                                                                        
                                                        </p>
                                                </div>

                                                <!-- create Comment -->
                                                <div class="card card-dark w-100 mb-2">
                                                        <div class="card-body">
                                                                <form action="" method="post" id="fmComment">
                                                                        <input type="text" placeholder="Enter Comment" class="form-control" id="comment"><br>
                                                                        <input type="submit" name=""  value="Create" class="btn btn-outline-warning float-right">
                                                                </form>
                                                        </div>
                                                </div>

                                                <!-- Comments -->
                                                <div class="card card-dark w-100">
                                                        <div class="card-header">
                                                                <h4>Comments</h4>
                                                        </div>
                                                        <div class="card-body">
                                                                <div id="comment_list">
                                                                         <!-- Loop Comment -->
                                                                <?php foreach($article->comments as $ac): ?>
                                                               
                                                               <div class='card-dark mt-1 '>
                                                                       <div class='card-body'>
                                                                               <div class='row'>
                                                                                       <div class='col-md-1'>
                                                                                               <img src='<?= DB::table('users')->where('id',$ac->user_id)->getOne()->image; ?>'
                                                                                                       style='width:50px;border-radius:50%'
                                                                                                       alt=''>
                                                                                       </div>
                                                                                       <div
                                                                                               class='col-md-4 d-flex align-items-center'>
                                                                                               <?= DB::table('users')->where('id',$ac->user_id)->getOne()->name; ?>
                                                                                       </div>
                                                                               </div>
                                                                               <hr>
                                                                               <p><?= $ac->comment ?></p>
                                                                       </div>
                                                               </div>
                                                               <?php endforeach; ?>

                                                                </div>
                                                               
                                                        </div>
                                                </div>
                                        </div>
                                </div>
<?php
require_once 'inc/footer.php';
?>
<script>
        // toastr.success("hello");
        //like
        var like = document.querySelector('#like');
        var like_count = document.querySelector('#like_Count')
        
        like.addEventListener('click',function(){
                var user_id = like.getAttribute('user_id');
                var article_id = like.getAttribute('article_id');

                if(user_id == 0)
                {
                        location.href = "login.php";
                }
                //axios
                axios.get(`api.php?like&user_id=${user_id}&article_id=${article_id}`)
                .then(function(res){
                        if(Number.isInteger(res.data))
                        {
                                toastr.success('like success');
                                like_count.innerHTML = res.data;
                                

                        }
                        if(res.data == "already_liked")
                        {
                                toastr.warning('liked');
                        }
                });

        });
        //comment
        var fmComment = document.getElementById('fmComment');
        var comment = document.getElementById('comment');
        var comment_list = document.getElementById('comment_list');
       
        fmComment.addEventListener('submit',function(e)
        {
                e.preventDefault();
              var data = new FormData();
              data.append('comment',comment.value);
              data.append('article_id',<?= $article->id ?>)
              axios.post('api.php',data)
              .then(function(res){
                        console.log(res.data);
                        comment_list.innerHTML = res.data;
              });
        


        });

        

</script>