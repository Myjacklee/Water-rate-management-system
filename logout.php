<?php
session_start();
if((isset($_SESSION["loginStatus"]["status"])&&$_SESSION["loginStatus"]["status"]==true)||(isset($_SESSION["admin"])&&$_SESSION["admin"]==true)){
    $_SESSION=array();
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),'',time()-42000,'/');
    }
    session_destroy();
    echo true;
}else{
    echo false;
}
?>