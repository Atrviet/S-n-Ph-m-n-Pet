<?php
    $severname = "localhost";
    $username = "root";
    $password = "";
    $db = "countryi_happet";
    $conn = new mysqLi($severname, $username , $password, $db);
    // 
    if($conn)
    {
        mysqli_query($conn, "SET NAMES 'utf8' ");
        //echo"success";
    }    
    else{
        // echo"falied";
    }
?>