<?php
    session_start();
    $_SESSION["S1"]="information!";
    $_SESSION["S2"]="text!";
    foreach ($_SESSION  as $value){
        echo $value.PHP_EOL;
    }
    $protocol = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https';
    $url=$protocol."://".$_SERVER["HTTP_HOST"].'/sessionText2.php';
    echo $url.PHP_EOL;
    Header("refresh:5,url=".$url);
?>
