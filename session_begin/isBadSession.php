<?php
if(!isset($_SESSION['_auth'])){
    $_SESSION['mess_age']="Unauthorized atempt to access a file or login session expired or your account may have been removed. Try to login again.";
    header('Location:login.php');
}

?>