<?php

date_default_timezone_set("Asia/Taipei");
session_start();



class DB {
private $dsn="mysql:host=localhost;charset=utf8;dbname=web01";
private $root='root';
private $password='';
private $pdo;
public function __construct($table){
  $this->table=$table;
  $this->pdo=new pdo($this->dsn,$this->root,$this->password);
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
public function math($method,$col,...$arg){
    $sql="SELECT $method($col) FROM $this->table ";

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
    

    return $this->pdo->query($sql)->fetchColumn();
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
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

}
function to($url){
    header("location:".$url);
}
$Total=new DB('total');
$Bottom=new DB('Bottom');
$Ad=new DB('ad');
$Mvim=new DB('mvim');
$Image=new DB('image');
$News=new DB('news');
$Admin=new DB('admin');
$Menu=new DB('menu');
// echo $Total->find(1)['total'];
// print_r($Total->all());
if (!isset($_SESSION['total'])) {
    $total=$Total->find(1);
    $total['total']++;
    $Total->save($total);
    $_SESSION['total']=$total['total'];
}
$cottom=$Bottom->save($cottom);
$views=$_POST['total'];
$total=$Total->find(1);
$total['total']=$views;
$total=$Total->save($total);
?>