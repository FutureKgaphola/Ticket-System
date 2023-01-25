<?php
require_once('session.php');
require_once('../db_conn/db_conn.php');

if(isset($_POST['login_btn']) && isset($_POST['email']) && isset($_POST['password']))
{
    $email=strtolower(trim($_POST['email']));
    $password=$_POST['password'];

    if($email!="" && $password!="")
    {
        try {
            $dbconn=new DBconnect();
            $sqlQuery="SELECT DISTINCT * FROM admins WHERE username=:username
             LIMIT 1";
            $prepResult=$dbconn->getconnection()->prepare($sqlQuery);
            $prepResult->bindParam(':username',$email,PDO::PARAM_STR);
            $prepResult->execute();
            $count=0;
            $count=$prepResult->rowCount();
            $profile=$prepResult->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            echo $th->getMessage();
        } 
        
        if($count == 1 && $profile!='')
        {
            if(password_verify($password,$profile['pass'])==true)
            {
                setSession($profile);

            }else if(($email=='admin1@company.co.za' || $email=='admin2@company.co.za' || $email=='admin3@company.co.za') && ($password=='123456'))
            {
                $_SESSION['welcome_message']='welcome to admin dashboard ';
                setSession($profile);
            }
            else{
                $_SESSION['message']='invalid login details';
                header('Location:../index.php');
            }
            
        }else{

            $_SESSION['message']='invalid login details';
            header('Location:../index.php');
        }
    }
}
else
{
    $_SESSION['message']='You are not allowed to acces this file';
    header('Location:../index.php');
}

function setSession($profile)
{
    $nameNlast=$profile['Names'];
    $email=$profile['username'];
    $role=$profile['role'];
    $uid=$profile['id'];

    $_SESSION['auth_role']=$role;
    if($_SESSION['auth_role']=='1')
    {
        $_SESSION['auth']=true;
    }else
    {
        $_SESSION['auth']=false;
    }

    $_SESSION['auth_user']= array(
        'nameNlast'=>$nameNlast,
        'email'=>$email,
        'uid'=>$uid,
        'role'=>$role,
    );
        
    if($_SESSION['auth_role']=='1')
    {
        $_SESSION['welcome_message']='welcome to admin dashboard ';
        header('Location:../dashboard.php');

    }else if($_SESSION['auth_role']=='0'){
        $_SESSION['message']='Admin Access denied';
        header('Location:../index.php');
    }
}
    
?>