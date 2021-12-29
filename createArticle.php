<?php require_once 'inc/header.php';

if(($_SERVER['REQUEST_METHOD'] == "POST"))
{
   if($_POST['title'] && $_POST['description'] && $_POST['language_id'])
   {
        $article =  Post::create($_POST);
   }
   else
   {
          $article = false;
   }
   
}


?>



<div class="card card-dark">
                                        <div class="card-header">
                                                <h3>Create New Article</h3>
                                        </div>
                                        <div class="card-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                <?php if(isset($article) && $article == "success"): ?>
                                                        <div class="alert alert-success">Article Create Successfully!</div>
                                                <?php elseif(isset($article) && $article == false): ?>
                                                        <div class="alert alert-danger">Article uploading failed. Fill all field !!!</div>
                                                <?php endif ?>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Title</label>
                                                                <input type="text" class="form-control"
                                                                        placeholder="Enter Title" name="title">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Choose Category</label>
                                                                <select name="category_id" id="" class="form-control">
                                                                    <?php 
                                                                    $cate = DB::table('category')->getAll();
                                                                    foreach($cate as $c):
                                                                    ?>
                                                                        <option value="<?= $c->id ?>"><?= $c->name ?></option>
                                                                        
                                                                    <?php endforeach; ?>
                                                                </select>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                               <?php
                                                               $lang = DB::table('languages')->getAll();
                                                               foreach($lang as $l):
                                                               ?>
                                                                <span class="mr-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                                name="language_id[]" value="<?= $l->id ?>">
                                                                        <label class="form-check-label"
                                                                                for="inlineCheckbox1"><?= $l->name; ?></label>
                                                                </span>
                                                                <?php endforeach; ?>
                                                        </div>
                                                        <br><br>
                                                        <div class="form-group">
                                                                <label for="">Choose Image</label>
                                                                <input type="file" class="form-control" name="image">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Articles</label>
                                                                <textarea name="description" class="form-control" id=""
                                                                        cols="30" rows="10"></textarea>
                                                        </div>
                                                        <input type="submit" value="Create"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>
<?php require_once 'inc/footer.php' ?>