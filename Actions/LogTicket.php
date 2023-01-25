<?php
require_once('session.php');
require_once('../db_conn/db_conn.php');
require_once('../MyClasses/logTicketClass.php');

if(isset($_POST['btnCreateTicket']) && isset($_POST['cfname']) && isset($_POST['clname'])
 && isset($_POST['cuemail']) && isset($_POST['cdesc'])
  && isset($_POST['department']) && isset($_POST['cordinatesLat']) && isset($_POST['cordinatesLon']))
{
    $cfname=trim($_POST['cfname']);
    $clname=trim($_POST['clname']);
    $cuemail=trim($_POST['cuemail']);
    $cdesc=trim($_POST['cdesc']);
    $dpt=trim($_POST['department']);
    $cordinatesLat=trim($_POST['cordinatesLat']);
    $cordinatesLon=trim($_POST['cordinatesLon']);
    $currentUserEmail=$_SESSION['auth_user']['email'];
    $currentUsernameNlast=$_SESSION['auth_user']['nameNlast'];
    $cordinatesLat=trim($_POST['cordinatesLat']);
    $cordinatesLon=trim($_POST['cordinatesLon']);
    $ticketNum=trim(uniqid());
    $anonymLink='https://boardroomlcx.000webhostapp.com/TicketSystem/Anonymous.php?tk='.$ticketNum.'&em='.$cuemail;

    $options=array('Sales','Accounts','IT');
    if(in_array($dpt,$options,true))
    {
        if(Auth_email($cuemail))
        {
            try { 
                $ticket= new AddTicket();
                $ticket->setTicket($ticketNum,$cuemail,$currentUserEmail,$cfname.' '.$clname,
                $cdesc,$dpt,"newly logged",$currentUsernameNlast,$cordinatesLat,$cordinatesLon,$anonymLink);

            } catch (RuntimeException $th) {
                echo $th->getMessage();
            }
        }
        else{
            $_SESSION['nulls_Found']='Error: Invalid email format';
            header('Location:../dashboard.php');
        }
    }else
    {
        $_SESSION['nulls_Found']='Error: Invalid category selection';
        header('Location:../dashboard.php');
    }

}else{
    header('Location:../dashboard.php');
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