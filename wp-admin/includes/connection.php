<?php

$db = mysqli_connect("localhost", "root", "", "ourtimes");

if ($db) {
    //echo "Database connection established!";
}else{
    die("Database connection error!".mysqli_error($db));
}

?>