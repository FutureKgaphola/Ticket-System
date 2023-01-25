<?php
require_once('session.php');
require_once('../db_conn/db_conn.php');

if(isset($_POST['btnUpdate']) && isset($_POST['edtId']) && isset($_POST['chStatus']))
{   
    $_uid=trim($_POST['edtId']);
    $status=trim($_POST['chStatus']);
    $options=array('newly logged','in progress','resolved');
    if(in_array($status,$options,true))
    {
        if($_uid!=null && $status!=null)
        {
            try
            {
                $dbconn=new DBconnect();
                // set the PDO error mode to exception
                $dbconn->getconnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql ="UPDATE tickets SET status=?
                    WHERE id=?  LIMIT 1";
    
                $stmt = $dbconn->getconnection()->prepare($sql);
    
                $stmt->execute([$status,$_uid]);
    
                if($stmt->rowCount()==1)
                {
                    $_SESSION['update_info']="Records updated successfully.";
                    header('Location:../dashboard.php');
                }else{
                $_SESSION['update_info']="No update done on the record";
                header('Location:../dashboard.php');
                }
            } catch (PDOException $e) 
            {
                $_SESSION['update_info']=$sql . "<br>" . $e->getMessage();
                header('Location:../dashboard.php');
            }
        }else
        {
            $_SESSION['update_info']="Unable to identify id or status";
            header('Location:../dashboard.php');
        }
        
    }else{
        $_SESSION['nulls_Found']='Error: Invalid category selection to change to '.$status;
        header('Location:../dashboard.php');
    }

}else{
    $_SESSION['update_info']="Method of accessing file is prohibited";
    header('Location:../dashboard.php');
}

?>