<?php

use function PHPSTORM_META\elementType;

require_once "inc/header.php";

if(isset($_GET['slug']))
{
    $slug = $_GET['slug'];
    $user = DB::table('users')->where('slug',$slug)->getOne();
   
}else
{
    Helper::redirect('404.php');
}
if(($_POST))
{
     $user = User::update($_POST);
    

}
?>
 

<div class="card card-dark">
   <div class="card-header bg-warning">
         <h3>Edit Profile</h3>
   </div>
   <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        
                <div class="form-group">
                         <label for="" class="text-white">Username</label>
                        <input type="text" name="name" class="form-control" value="<?= $user->name ?>">
                </div>
                <div class="form-group">
                         <label for="" class="text-white">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $user->email ?>">
                </div>
                 <div class="form-group">
                        <label for="" class="text-white">Password</label>
                        <input type="password" name="password" class="form-control">
                </div>
                <div>
                    <img src="<?= $user->image ?>" alt="img" width="200px" height="200px" style="border-radius: 20%;" >
                </div>
                <div class="form-group">
                    <!-- <label for="" class="text-white">Choose Image</label> -->
                    <input type="file" name="image" class="form-control mt-2">
                </div>
                

                <input type="submit" value="Save" class="btn  btn-outline-warning my-3 float-right">
                </form>
   </div>
</div>
<?php
require_once 'inc/footer.php';
?>