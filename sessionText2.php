<?php
session_start();
echo $_SESSION["S1"].PHP_EOL;
echo $_SESSION["S2"].PHP_EOL;
echo $_SERVER['HTTP_HOST'];

?>
