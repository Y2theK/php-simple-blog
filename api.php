<?php
require_once 'core/autoload.php';

$request = $_GET;
if(isset($request['like']))
{
    $user_id = $request['user_id'];
    $article_id = $request['article_id'];
    $u = DB::table('article_like')->where('user_id',$user_id)->andWhere('article_id',$article_id)->getOne();
    if($u)
    {
        echo 'already_liked';

    }else{
        $user = DB::create('article_like',[
            'user_id' => $user_id,
            'article_id' => $article_id
    
        ]);
        if($user)
        {
            $count = DB::table('article_like')->where('article_id',$article_id)->count();
            echo $count;
        }
    }
}
if(isset($_POST['comment']))
{
    $comment = $_POST['comment'];
    $article_id = $_POST['article_id'];
    $user_id = User::auth()->id;
    $comment = DB::create('article_comment',[
        'article_id' => $article_id,
        'user_id' => $user_id,
        'comment' => $comment
    ]);
    if($comment)
    {
        $cmt = DB::table('article_comment')->where('article_id',$article_id)->orderBy('id','desc')->getAll();
        $html = "";
        foreach($cmt as $c)
        {
            $user = DB::table('users')->where('id',$c->user_id)->getOne();

            $html .= "
            <div class='card-dark mt-1 '>
            <div class='card-body'>
                    <div class='row'>
                            <div class='col-md-1'>
                                    <img src='{$user->image}'
                                            style='width:50px;border-radius:50%'
                                            alt=''>
                            </div>
                            <div
                                    class='col-md-4 d-flex align-items-center'>
                                    {$user->name}
                            </div>
                    </div>
                    <hr>
                    <p>{$c->comment}</p>
            </div>
    </div>
            
            ";
        }
        echo $html;

    }
}
?>