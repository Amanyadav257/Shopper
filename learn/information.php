<?php

session_start();
if(isset($_SESSION['username'])){
echo "Welcome ".$_SESSION['username'];
echo "<br>";
echo "password ".$_SESSION['password'];
}
else{
    echo "please login";
}
?>