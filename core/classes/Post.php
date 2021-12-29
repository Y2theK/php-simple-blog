<?php

use function PHPSTORM_META\elementType;

class Post{
    public static function all()
    {
        $data = DB::table('articles')->orderBy('id','DESC')->paginate(3);
        foreach($data['data'] as $k=>$d)
        {
            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id',$d->id)->count();
        
        
        }
        return $data;
    }
    public static function search($search)
    {
     
        $data = DB::table('articles')->where('title','like',"%$search%")->orderBy('id','DESC')->paginate(3,"search=$search");
        foreach($data['data'] as $k=>$d)
        {
            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id',$d->id)->count();
        
        
        }
        return $data;
    }
    public static function articleByCategory($slug)
    {
        $category_id = DB::table('category')->where('slug',$slug)->getOne()->id;
        $data = DB::table('articles')->where('category_id',$category_id)->orderBy('id','DESC')->paginate(3,"category=$slug");
        foreach($data['data'] as $k=>$d)
        {
            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id',$d->id)->count();
        
        
        }
        return $data;
    }
    public static function ByUser()
    {
        $user_id = User::auth()->id;
        $data = DB::table('articles')->where('user_id',$user_id)->orderBy('id','desc')->paginate(3,"arti_user");
        foreach($data['data'] as $k=>$d)
        {
            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id',$d->id)->count();
        
        
        }
        return $data;
    }
    public static function delete($slug)
    {
        $id = DB::table('articles')->where('slug',$slug)->getOne()->id;
        $del_lang = DB::raw("delete from article_language where article_id = $id")->getAll();
        $del_comment = DB::raw("delete from article_comment where article_id = $id")->getAll();
        $del_like = DB::raw("delete from article_like where article_id = $id")->getAll();
        
        if(DB::delete('articles',$id) && $del_lang && $del_comment && $del_like)
            return true;
    }
    public static function articleByLanguage($slug)
    {
        $language_id = DB::table('languages')->where('slug',$slug)->getOne()->id;

        $data = DB::raw("SELECT * FROM article_language
        INNER JOIN articles ON
        articles.id = article_language.article_id
        WHERE article_language.language_id=$language_id")->orderBy('articles.id','desc')->paginate(3,"language=$slug");
        
        foreach($data['data'] as $k=>$d)
        {
            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id',$d->id)->count();
        
        
        }
        
        
       
        return $data;
    }
    public static function detail($slug)
    {
        //article
        $data = DB::table('articles')->where('slug',$slug)->getOne();
        //language
        
        $data->languages = DB::raw("SELECT languages.id,languages.slug,languages.name FROM article_language
        LEFT JOIN languages
        on article_language.language_id=languages.id 
        WHERE article_id=$data->id")->getAll();
        //category
        $data->category = DB::table('category')->where('id',$data->category_id)->getOne();

        //like_count
        $data->like_count = DB::table('article_like')->where('article_id',$data->id)->count();

        //comment_count
        $data->comment_count = DB::table('article_comment')->where('article_id',$data->id)->count();

        //comment
        $data->comments = DB::table('article_comment')->where('article_id',$data->id)->getAll();
        return $data;
    }
    public static function edit($request,$arti_id)
    {
        $slug = Helper::slug($request['title']);
        $title = $request['title'];
        $description = $request['description'];
        $category_id = $request['category_id'];
        $user_id = User::auth()->id;
        $language_id = $request['language_id'];
         //move file to image
         if(isset($_FILES['image']) && $_FILES['image']['tmp_name'] != "")
         {
           $tmp_name = $_FILES['image']['tmp_name'];
           $image_name = $_FILES['image']['name'];
           $file_path = "assets/image/".$image_name;
           (move_uploaded_file($tmp_name,$file_path));
         }
         else
         {
             $arti = DB::table('articles')->where('id',$arti_id)->getOne();
             $file_path = $arti->image;
         }
         $article =  DB::update('articles',[
            'user_id' => $user_id,
            'category_id' => $category_id,
            'slug' => $slug,
            'title' => $title,
            'image' => $file_path,
            'description' => $description
        ],$arti_id);

           
            $old_l = DB::table('article_language')->where('article_id',$arti_id)->getAll();
            $new_l = $language_id;
            foreach($old_l as $ol)
            {
               $olang[] = $ol->language_id;
            }
            if($olang != $new_l)
            {
                $del = DB::raw("delete from article_language where article_id = $arti_id")->getAll();
                print_r($del);
                if($article)
                {
                    //update into article_language table
                    $article_id = $article->id;
                    
                    foreach($language_id as $lid)
                    $arti_lang = DB::create('article_language',[
                    'article_id' => $article_id,
                    'language_id' => $lid

                    
                ]);
                    
                }
                // die();
            }
            
        
           
           {
               
            }
            
            
            if($article)
            {
                return "success";
            }
           
            else{
                return false;
                //validate 
            }


    }
    public static function create($request)
    {
        

        $slug = Helper::slug($request['title']);
        $title = $request['title'];
        $description = $request['description'];
        $category_id = $request['category_id'];
        $user_id = User::auth()->id;
        $language_id = $request['language_id'];

          //move file to image
          if(isset($_FILES['image']) && $_FILES['image']['tmp_name'] != "")
          {
            $tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $file_path = "assets/image/".$image_name;
            (move_uploaded_file($tmp_name,$file_path));
          }else
          {
              $file_path = "";
          }
          
         

              // upload into article table
             $article =  DB::create('articles',[
            'user_id' => $user_id,
            'category_id' => $category_id,
            'slug' => $slug,
            'title' => $title,
            'image' => $file_path,
            'description' => $description
        ]);
            //upload into article_language table
            if($article)
            {
                $article_id = $article->id;
                foreach($language_id as $lid)
                $article = DB::create('article_language',[
                'article_id' => $article_id,
                'language_id' => $lid

                
            ]);
            return "success";
            }else{
                return false;
                //validate 
            }

    }
         
      
        
        
        

        

}

    

?>