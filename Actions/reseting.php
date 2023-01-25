<?php
require_once('session.php');
require_once('../db_conn/db_conn.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['btnSentReset']) && isset($_POST['edtem']))
{
    $selector=bin2hex(random_bytes(8));
    $toke=random_bytes(32);
    $url="https://boardroomlcx.000webhostapp.com/TicketSystem/resetpage.php?selector=".$selector."&validator=".bin2hex($toke);
    $expires=date('U')+1800;
    $UserExist=false;
    $emali=$_POST['edtem'];
    $dbconn=new DBconnect();
    $stmt=$dbconn->getconnection()->prepare("SELECT * FROM admins WHERE username=? LIMIT 1");
    $stmt->execute([strtolower(trim($emali))]);
    $validusers=$stmt->fetchAll();
    foreach($validusers as $user)
    {
        if(strtolower(trim($user['username']))==strtolower(trim($emali)))
        {
            $UserExist=true;
        }
    }
    if($UserExist==true)
    {
            $dbcon=new DBconnect();

            $sql = "DELETE FROM pwReset WHERE pwdResetEmail=?";
            if(!$dbcon->getconnection()->prepare($sql))
            {
                $_SESSION['message']='Could not connect to complete the request';
                header("Location:../index.php");
        
            }else{
                $stmt=$dbcon->getconnection()->prepare($sql);
                $stmt->execute([$emali]);
               
            }
            $dbcon=new DBconnect();
            $sql="INSERT INTO pwReset (pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpires)
            VALUES (?,?,?,?)";
            
            if(!$dbcon->getconnection()->prepare($sql))
            {
                $_SESSION['message']='Could not connect to complete the request';
                header("Location:../index.php");

            }else{
                $hashedToken=password_hash($toke,PASSWORD_DEFAULT);
    
                $stmt=$dbcon->getconnection()->prepare($sql);
                $stmt->execute([$emali,$selector,$hashedToken,$expires]);
    
                $htmldetails ="<p>We received a password reset request. if this is not you then you can ignore this email</p><br>";
                $htmldetails.="<p>Here is your reset link: <br>";
                $htmldetails.='<a href="'.$url.'">'.$url.'</a></p>';
                    ///send email
                $subject = "Password Reset for Ticket Log system";
                
                sendnewmail($htmldetails,$emali,$subject);
            }
    }else{
        header("Location:../index.php");
    }
      
}else{
    header("Location:../index.php");
}


function sendnewmail($msgnew,$clientUsername,$subjectnew)
{
    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';

    if($clientUsername!=null && $msgnew!=null && $subjectnew!=null)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'devslcx@gmail.com';                     //SMTP username
            $mail->Password   = 'wmunbjwdgmejcjpk';                               //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->SMTPSecure='ssl';           //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('devslcx@gmail.com');
            $mail->addAddress(trim($clientUsername));     //Add a recipient
        
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('appIcon.png', 'appIcon.png');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subjectnew;
            $mail->Body    = $msgnew;
            $mail->AltBody = $msgnew;

            if($mail->send())
            {
                $_SESSION['message']='Email Message has been sent to '.trim($clientUsername);
                header('Location:../index.php');
            }else{
                $_SESSION['message']="Message could not be sent to ".trim($clientUsername);
                header('Location:../index.php');
            }
        } catch (Exception $e) {
            $_SESSION['message']="Message could not be sent to ".trim($clientUsername)." Mailer Error: {$mail->ErrorInfo}";
            header('Location:../index.php');
        }
    }
}
?>