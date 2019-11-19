<?php

try{
$db = new PDO("mysql:host = localhost;dbname=messenger","root","");
echo "success";
} catch(PDOException $e){
    echo $e->getMessage();
}

$name = "John Muyambo updated";
$email = "john@gmail.com updated";
$password = "passw01 updated";
$id = 2;

//$Query = $db->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
//$Query->execute(array($name, $email, $password));
//if($Query){
//    echo "Data is inserted successfully";
//} else {
 //   echo "sorry something went wrong";
//}

//$Query = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
//$Query->execute(array($name,$id));
//if($Query){
//    echo "record is successfully updated";
//} else {
//    echo "sorry something went wrong";
//}

//$Query = $db->prepare("DELETE FROM users WHERE id = ?");
//$Query->execute(array($id));
//if($Query){
//    echo "record is successfully deleted";
//} else {
//    echo "sorry something went wrong";
//}

$Query = $db->prepare("SELECT * FROM users");
$Query->execute();
if($Query->rowCount() > 0 ){
   $rows = $Query->fetchAll(PDO::FETCH_OBJ);
   echo "<pre>";
   print_r($rows);
} else{
    echo "sorry no records found";
}



?>