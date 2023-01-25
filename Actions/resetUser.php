<?php
    if(isset($_POST['btnReset']) && isset($_POST['selector'])
     && isset($_POST['validator']) && isset($_POST['pwd']) && isset($_POST['pwdR']))
    {
        $currentdate=date('U');
        $selector=$_POST['selector'];
        $validator=$_POST['validator'];
        $paswrd=$_POST['pwd'];
        $pswrdRepaet=$_POST['pwdR'];
        
        if(empty($paswrd) || empty($pswrdRepaet))
        { 
            header("Location:../resetpage.php?ns=password cannot be empty");
        }elseif($paswrd!=$pswrdRepaet)
        {
            header("Location:../resetpage.php?ns=password does not match");
        }
        
        require('../db_conn/db_conn.php');
        
        $dbconn=new DBconnect();
        $sql="SELECT * FROM pwReset WHERE
        pwdResetSelector=? AND pwdResetExpires>=? LIMIT 1";
        if(!$dbconn->getconnection()->prepare($sql))
        {
            echo 'There was an error while attempting request';
        }else{
            
            $stmt=$dbconn->getconnection()->prepare($sql);
            $stmt->execute([$selector,$currentdate]);
            $validusers =$stmt->fetchAll();
            $maxrows=0;
            foreach($validusers as $users)
            {
                $maxrows++;
                $tokenBinary=hex2bin($validator);
                $tokenCheck=password_verify($tokenBinary,$users['pwdResetToken']);
                if($tokenCheck==false)
                {
                    $_SESSION['message']='You need to re submit your reset request';
                    header("Location:../index.php");
                }elseif($tokenCheck==true)
                {
                    $TokenEmail=$users['pwdResetEmail'];
                    
                    $dbconn=new DBconnect();
                    $sql="SELECT * FROM admins WHERE
                    username=?";
                    if(!$dbconn->getconnection()->prepare($sql))
                    {
                    echo 'There was an error while attempting request';
                    }else{
                        try{
                            $dbconn=new DBconnect();
                            
                            $dbconn->getconnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql ="UPDATE admins SET pass=? WHERE username=? LIMIT 1";
                            
                            
                            $stmt = $dbconn->getconnection()->prepare($sql);
                            $newpasHash=password_hash($pswrdRepaet,PASSWORD_DEFAULT);
                            
                            $stmt->execute([$newpasHash,$TokenEmail]);
                            if($stmt->rowCount()>0)
                            {
                                echo $stmt->rowCount(). " records UPDATED successfully";
                                $dbcon=new DBconnect();
                                $sql = "DELETE FROM pwReset WHERE pwdResetEmail=?";
                                if(!$dbcon->getconnection()->prepare($sql))
                                {
                                    echo 'There was an error while attempting request';
                                    
                                }else{
                                    $stmt=$dbcon->getconnection()->prepare($sql);
                                    $stmt->execute([$TokenEmail]);
                                    $_SESSION['message']='Your password was reset sucessfully';
                                    header("Location:../index.php");                                   
                                }
                            }
                        }catch(PDOException $k)
                        {
                            echo $k->getMessage();
                        }
                    }

                }
            }
            if($maxrows==0)
            {
                header("Location:../resetpage.php?ns=You need to re-submit your request by entering the email you want to reset for.");
            }
        }
        
    }else{
        header("Location:../resetpage.php");
}

?>