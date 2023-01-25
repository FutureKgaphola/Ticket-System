<?php
require_once('session.php');
require_once('../db_conn/db_conn.php');
require_once('../MyClasses/AddAdminClass.php');

if(isset($_POST['btnCreate']) && isset($_POST['fname']) && isset($_POST['lname'])
 && isset($_POST['uemail']))
{
    $name=trim(strtolower($_POST['fname']));
    $email=trim(strtolower($_POST['uemail']));
    $role='1';
    $lname=trim(strtolower($_POST['lname']));
    $randomBytes=random_bytes(32);

    $hashedpassword=password_hash($randomBytes,PASSWORD_DEFAULT);
    if(empty($name)==true || empty($email)==true || empty($role)==true || empty($lname)==true )
    {
        $_SESSION['nulls_Found']='Error: Some fields appears to be empty or whitespace.
        Do not input empty space or whitespace';
        header('Location:../dashboard.php');

    }else
    {
        if(Auth_email($email)==true)
        {
            try { 
                $user= new AddAdmin();
                $user->setMember($email,$hashedpassword,$name,$lname,$role);

            } catch (RuntimeException $th) {
                echo $th->getMessage();
            }

        }else
        {
            $_SESSION['Authfailed']='Email fields failed authentication';
            header('Location:../dashboard.php');

        }  
    }
}


function Auth_email($em)
{
    $valid=false;
    try{
        if(filter_var($em, FILTER_VALIDATE_EMAIL))
        {
            $valid=true;
        }

    }catch(Exception $th)
    {
        echo $th->getMessage();
    }
    return $valid;
}

?>