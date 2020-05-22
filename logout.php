<?php
session_start();
if(isset($_SESSION["loginStatus"]["status"])&&$_SESSION["loginStatus"]["status"]===true){
    session_destroy();
    setcookie(session_name(),'',time()-3600);
    echo true;
}else{
    echo false;
}
?>