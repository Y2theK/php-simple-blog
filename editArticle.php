<?php require_once 'inc/header.php';

if(isset($_GET['slug']))
{
    $slug = $_GET['slug'];
    $article = DB::table('articles')->where('slug',$slug)->getOne();
       
   
}
if(($_SERVER['REQUEST_METHOD'] == "POST"))
{

        $slug = $_GET['slug'];
        $arti_id = DB::table('articles')->where('slug',$slug)->getOne()->id;
       
        
        $article = Post::edit($_POST,$arti_id);
        print_r($article);
       
        
}

?>



<div class="card card-dark">
                                        <div class="card-header">
                                                <h3>Edit Article</h3>
                                        </div>
                                        <div class="card-body">
                                        <?php if($article == "success"): ?>
                                        
                                        <div class="alert alert-success">Updated Successfully</div>
                                        <?php Helper::redirect('index.php'); die(); ?>
                                        <?php elseif($article==false): ?>
                                                <div class="alert alert-danger">Updated failed</div>
                                        <?php endif; ?>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Edit Title</label>
                                                                <input type="text" class="form-control"
                                                                        value="<?= $article->title ?>" name="title">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Choose Category</label>
                                                                <select name="category_id" id="" class="form-control">
                                                                
                                                                    <?php 
                                                                    $old_cate = DB::table('category')->where('id',$article->category_id)->getOne();
                                                                    $cate = DB::table('category')->getAll();
                                                                    ?>
                                                                    

                                                                    <?php
                                                                    foreach($cate as $c)
                                                                    {
                                                                        $selected = $c->id == $old_cate->id ? 'selected' : '';
                                                                        echo "
                                                                        <option value='{$c->id}' $selected>{$c->name}</option>
                                                                        ";
                                                                    }
                                                                           
                                                                        
                                                                    ?>
                                                                        
                                                                    
                                                                </select>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                               <?php
                                                               $lang = DB::table('languages')->getAll();
                                                               $old_lang = DB::table('article_language')->where('article_id',$article->id)->getAll();
                                                               if(!$old_lang)
                                                               {
                                                                foreach($lang as $l)
                                                                {
                                                                         
                                                                  echo "<span class='mr-2'>
                                                                                 <input class='form-check-input' type='checkbox'
                                                                                 name='language_id[]' value='$l->id'$checked>
                                                                                 <label class='form-check-label'
                                                                                 for='inlineCheckbox1'>$l->name</label>
                                                                                 </span>";
                                                                 }
                                                               }
                                                               else
                                                               {
                                                                foreach($lang as $l)
                                                                {
                                                                         foreach($old_lang as $ol)
                                                                         {
                                                                         
                                                                                 $checked = $ol->language_id == $l->id ? "checked": '';
                                                                                 if($checked == "checked")
                                                                                 {
                                                                                         break;
                                                                                 }
                                                                                 
                                                                         
                                                                         }
                                                                  echo "<span class='mr-2'>
                                                                                 <input class='form-check-input' type='checkbox'
                                                                                 name='language_id[]' value='$l->id'$checked>
                                                                                 <label class='form-check-label'
                                                                                 for='inlineCheckbox1'>$l->name</label>
                                                                                 </span>";
                                                                 }
                                                               }
                                                              
                                                               ?>
                                                        </div>
                                                        <br><br>
                                                        <div class="form-group">
                                                                <label for="">Edit Image</label>
                                                                <input type="file" class="form-control" name="image">
                                                        </div>
                                                        <?php
                                                        if($article->image):
                                                        ?>
                                                        <div class="form-group">
                                                                <img src="<?= $article->image ?>" alt="" width="200px" height="200px">
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Articles</label>
                                                                <textarea name="description" class="form-control" id=""
                                                                        cols="30" rows="10" ><?= $article->description ?></textarea>
                                                        </div>
                                                       <!-- <input type="cancel" value="Cancel" class="btn btn-outline-dark float-right"> -->
                                                        <input type="submit" value="Update"
                                                                class="btn  btn-outline-warning float-right" >
                                                        
                                                </form>
                                        </div>
                                </div>
<?php require_once 'inc/footer.php' ?>