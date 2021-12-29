<?php
class User{
    //auth
    public static function auth()
    {
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            return DB::table('users')->where('id',$user_id)->getOne();
        }else{
            return false;
        }
    }
    public function login($request)
    {
        $error = [];
        if(isset($request))
        {
            $email = Helper::filter($request['email']);
             $password = $request['password'];
         //check email
         $user = DB::table('users')->where('email',$email)->getOne();

         //password verify
         if($user)
         {
             $db_password = $user->password;
             if(password_verify($password,$db_password)){
                 $_SESSION['user_id'] = $user->id;
                 return "success";
             }
             else{
                 //wrong password
                 $error[] = "Wrong Password";
             }
            
         }
         else
         {
             //wrong email
             $error[] = "Wrong Email";
             

         }
         return $error;

        }
        
        
    }


    public static function update($request)
    {
        $user = User::auth();
        $name = $_POST['name'];
        $email = $_POST['email'];

        
        //move image files
        $image = $_FILES['image'];
        if(isset($image) && $image['tmp_name'] != "")
        {
            
            $image_name = $image['name'];
            $file_path = "assets/user/$image_name";
            $tmp_name = $image['tmp_name'];
            move_uploaded_file($tmp_name,$file_path);
            

        }else
        {
            $file_path = $user->image;
        }
       
             

    
        // UPDATE
        $data = DB::update('users',[
                'name' => $name,
                'image' => $file_path,
                'email' => $email,
               
            ],$user->id);
        
        if($data)
        {
            return $data;
        }
        
        

    }
    public function register($request)
    {
        $error = [];
        if(isset($request)){
            if(empty($request['name'])){
                $error[] = 'Name is Required';
            }
            if(empty($request['email'])){
                $error[] = 'Email is Required';
            }
            if(!filter_var($request['email'],FILTER_VALIDATE_EMAIL)){
                $error[] = 'Invaid Email Format';
            }
            if(empty($request['password'])){
                $error[] = 'Password is Required';
            }
            //check email already exist
            $user = DB::table('users')->where('email',$request['email'])->getOne();
            if($user)
            {
                $error[] = "Email already exist";
            }
            if(count($error))
            {
                return $error;
            }else
            {
                
                //insert data
                $user = DB::create('users',[
                    'name' => Helper::filter($request['name']),
                    'slug' => Helper::slug($request['name']),
                    'email' => Helper::filter($request['email']),
                    'password' => (password_hash($request['password'],PASSWORD_BCRYPT))
                ]);

                //session user id
                $_SESSION['user_id'] = $user->id;
                return "success";
                //header index
                
                //
            }
        }
    }
}