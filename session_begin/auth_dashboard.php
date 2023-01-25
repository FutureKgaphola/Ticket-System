<?php

if(!isset($_SESSION['auth']) || $_SESSION['auth']==false)
{
    session_destroy();
    header('Location:index.php'); 
}

?>