<?php
class DB{
    private $dsn="mysql:host=localhost,charset=utf8,dbname=web01";
    private $root='root';
    private $password='';
    private $table;
    public function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->root,$this->password);
    }
    public function find($id){
        $sql="SELECT*FROM $this->table WHERE";
    
        if(is_array($id)){
            foreach($id as $key=>$value){
                $tmp[]="`$key`='$value'";
            }
            $sql .=implode(" AND ",$tmp);
        }else{
            $sql .="`id`='$id'";
        }
    
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function all(...$arg){
        $sql="SELECT *FROM $this->table ";
        
        switch(count($arg)){
            case 2:
                foreach($arg[0] as $key=>$value){
                    $tmp[]="`$key`='$value'";
                }
                $sql .=" WHERE ".implode(" AND ".$arg[0])." ".$arg[1];
            break;
        
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key=>$value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql .=" WHERE ".implode(" AND ".$arg[0]);
                }else{
                    $sql .= $arg[1];
                }
            break;
        }
        
            return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } 
        public function save($array){
            if (isset($array['id'])) {
                foreach($array as $key=>$value){
                    $tmp[]="`$key`='$value'";
                }
                $sql="UPDATE $this->table 
                SET ".implode(",",$tmp)."
                WHERE `id`='{$array['id']}'";
            }else{
                $sql="insert into $this->table (`".implode("`,`",array_keys($array))."`) 
                values('".implode("','",$array)."')";
                echo $sql;
            }
            return $this->pdo->exec($sql);
        }  
        public function del($id){
            $sql="DELETE FROM $this->table WHERE";
        
            if(is_array($id)){
                foreach($id as $key=>$value){
                    $tmp[]="`$key`='$value'";
                }
                $sql .=implode(" AND ",$tmp);
            }else{
                $sql .="`id`='$id'";
            }
            return $this->pdo->exec($sql);
        }  
public function q($sql){
    return $this->query($sql)->fetchALL(PDO::FETCH_ASSOC);
}
function to($url){
    header("location:".$url);
}



?>