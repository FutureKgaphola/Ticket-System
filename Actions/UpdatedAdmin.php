<?php
require_once('session.php');
require_once('../db_conn/db_conn.php');

if(isset($_POST['btnAdminUpdate']) && isset($_POST['Admin_Name'])
 && isset($_POST['Admin_lastname']))
{
    
    $Admin_Name=strtolower(trim($_POST['Admin_Name']));
    $Admin_lastname=strtolower(trim($_POST['Admin_lastname']));
    
    $authUid=$_SESSION['auth_user']['uid'];
    $authemail=$_SESSION['auth_user']['email'];
    $authrole=$_SESSION['auth_user']['role'];

    if((strtolower(trim($authemail))=='admin1@company.co.za' || strtolower(trim($authemail))=='admin2@company.co.za' || strtolower(trim($authemail=='admin3@company.co.za'))))
    {
        $_SESSION['update_info']='Can not update system reserved account.';
        header('Location:../dashboard.php');
    }else{

        if($authrole=='1')
        {
            try {
                $dbconn=new DBconnect();
                // set the PDO error mode to exception
                $dbconn->getconnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql ="UPDATE admins SET Names=?
                WHERE id=? AND username =? AND role=? LIMIT 1";
        
                // Prepare statement
                $stmt = $dbconn->getconnection()->prepare($sql);
                $stmt->execute([$Admin_Name.' '.$Admin_lastname,
                    $authUid,$authemail,$authrole]);
                
                if($stmt->rowCount()==1)
                {
                    $_SESSION['auth_user']['nameNlast']=$Admin_Name.' '.$Admin_lastname;
                    $_SESSION['update_info']="Records updated successfully";
                    header('Location:../dashboard.php');             
                }else{
                    $_SESSION['update_info']="No change were made.";
                header('Location:../dashboard.php');
                }
                
            } catch(PDOException $e) {
                $_SESSION['update_info']=$sql . "<br>" . $e->getMessage();
                header('Location:../dashboard.php');
            }

        }else{
            $_SESSION['update_info']="error. Invalid authentication role";
            header('Location:../dashboard.php');
        }
    }

}else{
    //log out
    $_SESSION['update_info']="error: prohibited file entry";
    header('Location:../dashboard.php');
    
}

?>