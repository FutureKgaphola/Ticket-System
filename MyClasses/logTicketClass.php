<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
class AddTicket extends DBconnect
{
    public function setTicket($ticketNum,$clientUsername, $AdminUsername,
     $clientName, $description, $department,$status,
     $loggedby,$lat,$lon,$anonymousLnk)
    {
        try {
            
            $sql = "INSERT INTO tickets (ticketNum,clientUsername, AdminUsername,
            clientName, description, department,status,
            loggedby,lat,lon,anonymousLnk)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $dbcon = new DBconnect();
                $stmt = $dbcon->getconnection()->prepare($sql);
                if ($stmt->execute([$ticketNum,$clientUsername, $AdminUsername,
                $clientName, $description, $department,$status,
                $loggedby,$lat,$lon,$anonymousLnk])) {
                    sentEmail($clientUsername,$clientName,$description,$anonymousLnk);
                    $_SESSION['update_info'] = "Ticket created for : " . $clientName;
                    header('Location:../dashboard.php');
                }
            
        } catch (PDOException $th) {
            $_SESSION['update_info'] = $th->getMessage();
            header('Location:../dashboard.php');
        }
    }

}
function sentEmail($clientUsername,$clientName,$description,$anonymousLnk)
{
    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';

    if($clientUsername!=null && $clientName!=null && $description!=null && $anonymousLnk!=null)
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
            $mail->Subject = 'Ticket System log confirmation.';
            $mail->Body    = 'Hi, '.$clientName. '<br>This serves as confirmation of your issue logged as follows:<br><br> '.$description. '. <br><br>This information is only private and confidential to you.
            click on track progress to monitor you issue:<br><button><a href ='.$anonymousLnk.'>track progress</a></button><br><br><b>Thank you. Regards Ticket Logging System Team</b>';
            $mail->AltBody = 'Hi, '.$clientName. '<br>This serves as confirmation of your issue logged as follows:<br><br> '.$description. '. <br><br>This information is only private and confidential to you.
            click on track progress to monitor you issue:<br><button><a href ='.$anonymousLnk.'>track progress</a></button><br><br><b>Thank you. Regards Ticket Logging System Team</b>';
        
            if($mail->send())
            {
                $_SESSION['nulls_Found']='Email Message has been sent to '.trim($clientUsername);
            }else{
                $_SESSION['nulls_Found']="Message could not be sent to ".trim($clientUsername);
            }

        } catch (Exception $e) {
            $_SESSION['Authfailed']="Message could not be sent to ".trim($clientUsername)." Mailer Error: {$mail->ErrorInfo}";
            header('Location:../dashboard.php');
        }

    }
}

?>