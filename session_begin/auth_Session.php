<?php

if(isset($_SESSION['auth']) && $_SESSION['auth']==true)
{
    header('Location:dashboard.php');
}else{
    session_destroy();
    //header('Location:index.php');
}

?>