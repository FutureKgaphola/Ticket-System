<?php

require_once('session.php');
require_once('../db_conn/db_conn.php');

if(isset($_POST['deletebtn']) && isset($_POST['edtId']))
 {
    $id=$_POST['edtId'];
    $dbId=null;

    $dbconn=new DBconnect();
    $stmt=$dbconn->getconnection()->prepare("SELECT id FROM tickets WHERE id=? LIMIT 1");
    $stmt->execute([trim($id)]);
    $validrecord=$stmt->fetchAll();
    foreach($validrecord as $record)
    {
        $dbId=$record['id'];
    }
    if($dbId!=null && $id!=null && ($id==$dbId))
    {
        $dbcon=new DBconnect();

        $sql = "DELETE FROM tickets WHERE id=?";
        if(!$dbcon->getconnection()->prepare($sql))
        {
            $_SESSION['update_info']="Invalid query format detected";
            header('Location:../dashboard.php');
        
        }else{
            $stmt=$dbcon->getconnection()->prepare($sql);
            $stmt->execute([$id]);
            if($stmt->rowCount()>0)
            {
                $_SESSION['update_info']=$stmt->rowCount()." record deleted successful";
                header('Location:../dashboard.php');
            }
            else{
                $_SESSION['update_info']="Invalid query format detected or data already deleted";
                header('Location:../dashboard.php');
            }
        }
    }else{
        $_SESSION['update_info']="Unable to delete Record or data already deleted";
        header('Location:../dashboard.php');
    }
 }else
 {
    header('Location:../dashboard.php');
 }
?>