<?php

include "connection.php";
ob_start();

//delete function here
 
function delete($table,$table_id,$delete_id,$page_url){
    global $db;

    $query = "DELETE FROM $table WHERE $table_id = '$delete_id'";
    $result = mysqli_query($db,$query);
    if($result){
     header('Location: '.$page_url);
    }else{
     die("Delete Category Error!".mysqli_error($db));
    }
 }
ob_end_flush();

?>