<?php 
class DB
{
    private static $dbh = null;
    private static $res,$data,$count,$sql;
    public function __construct()
    {
        self::$dbh = new PDO("mysql:host=localhost;dbname=blog_project","root","");
        self::$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    public function query($params = [])
    {
        self::$res = self::$dbh->prepare(self::$sql);
        self::$res->execute($params);
       
        
        return $this;

    }
    public function getAll()
    {
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        
        return self::$data;
    }
    public function getOne()
    {
        $this->query();
        self::$data = self::$res->fetch(PDO::FETCH_OBJ);
        return self::$data;
    }
    public function count(){
        self::$count = self::$res->rowCount();
        return self::$count;
    }
    public static function table($table_name)
    {
        $sql = "select * from $table_name";
        self::$sql = $sql;
        $db = new DB();
        
        return $db; // same as $this
    }
    public function orderBy($col,$value)
    {
        self::$sql .= " order by $col $value";
        $this->query();
        return $this;
    }
    public function where($col,$operator,$value = 1)
    {
       
        if(func_num_args() == 2)  //count of arguments that has been put to function when calling
        {
            self::$sql .= " where $col = '$operator'";
            
        }
        else
        {
            self::$sql .= " where $col $operator '$value'";
        }
        // echo self::$sql;
        $this->query();
        return $this;
    }
    public function andWhere($col,$operator,$value = 1)
    {
       
        if(func_num_args() == 2)  //count of arguments that has been put to function when calling
        {
            self::$sql .= " and $col = '$operator'";
            
        }
        else
        {
            self::$sql .= " and $col $operator '$value'";
        }
        // echo self::$sql;
        $this->query();
        return $this;
    }
    public function orWhere($col,$operator,$value = 1)
    {
       
        if(func_num_args() == 2)  //count of arguments that has been put to function when calling
        {
            self::$sql .= " or $col = '$operator'";
            
        }
        else
        {
            self::$sql .= " or $col $operator '$value'";
        }
        // echo self::$sql;
        $this->query();
        return $this;
    }
    public static function create($table_name,$data){
        
        $arr_key = implode(',',array_keys($data));
        $arr_values = array_values($data);
         $question_mark = "";
         $count = 1;
         foreach($data as $d)
         {
            $question_mark .= "?";
            
            if($count < count($data))
            {
                $question_mark .= ',';
                $count++;
               
            }

           
         }
         
         $sql =  "insert into $table_name ($arr_key) values ($question_mark)";
         self::$sql = $sql;
         $db = new DB;
         $db->query($arr_values);
         $id = self::$dbh->lastInsertId();
         return $db::table($table_name)->where('id',$id)->getOne();
          
         
         
    }
    public static function update($table_name,$data,$id)
    {
      
       
       $key_question = "";
       
       foreach($data as $key=>$value)
       {
           $key_question .= "$key = ? ,";
        
        }
        $key_question = rtrim($key_question,','); //trim final comma
        $sql = "update $table_name set $key_question where id = $id";
        $arr_values = array_values($data);
        self::$sql = $sql;
        $db = new DB();
        $db->query($arr_values);
        return $db::table($table_name)->where('id',$id)->getOne();
    }
    public static function delete($table_name,$id)
    {
        $sql = "delete from $table_name where id = '$id'";
        $db = new DB();
        self::$sql = $sql;
        $db->query();
        return true;
    }
    public function paginate($record_per_page,$append='')
    {
        if(isset($_GET['page']))
        {
            $page_no = $_GET['page'];
            if($page_no < 1)
            {
                $page_no = $_GET['page'] = 1;
            }
        }
        if(!isset($_GET['page']))
        {
            $page_no = 1;
        }
        $this->query();
        $count = self::$res->rowCount();
       
        //formula
        $start = ($page_no-1)*$record_per_page;

        self::$sql .= " limit $start,$record_per_page";
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        
        $prev_page = "?page=".$page_no-1;
        $next_page = "?page=".$page_no+1;

        $dataArray = [
            "data" => self::$data,
            "total" => $count,
            "prev_page" => $prev_page."&$append",
            "next_page" => $next_page."&$append"

        ];
       
        return $dataArray;
    }
    public static function raw($sql)
    {
        self::$sql = $sql;
        $db = new DB();
        return $db;
    }


}

?>


