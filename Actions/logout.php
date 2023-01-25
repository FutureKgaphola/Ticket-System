<?php
require('session.php');

if(isset($_POST['btnlogout']))
{
    session_destroy();
    header('Location:../index.php');
}
else
{
    session_destroy();
    header('Location:../index.php');
}
?>