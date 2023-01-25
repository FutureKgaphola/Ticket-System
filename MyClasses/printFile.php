<?php
if(session_status() !== PHP_SESSION_ACTIVE || session_status() === PHP_SESSION_NONE)
{
    session_start();
}
require('./library/fpdf.php');

class myPDF extends FPDF{
    function Header()
    {
        $this->Image('img/confidential.png',40,10,70);
    }
    function Footer()
    {
        date_default_timezone_set('Africa/Johannesburg');
        $date = new DateTime();
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->ln();
        $this->cell(188,5,'Print date: '.$date->format('Y-m-d H:i:s'),0,1,'L');
    }

    function spaceby_Y($moveby)
    {
        for ($x = 0; $x <= 3; $x++) {
        $this->cell(180,$moveby,'',0,1,'C');
        }

    }

    function getBookingsStandings()
    {
        try{
            $host="localhost";
            $username="id17952374_boardroom";
            $password="2021@Lcx.Devs";
            $database="id17952374_boardroomlcx_db";
            $DBconn=new PDO("mysql:host=$host;dbname=$database",$username,$password);
            $stmt=$DBconn->prepare("SELECT * FROM tickets");
            $stmt->execute();
            $result=$stmt->fetchAll();

            foreach ($result as $item)
            {
                $this->ln();
                $this->SetFont('Arial','',8);
                $this->Cell(20,10,$item['id'],1,0,'L');
                $this->Cell(30,10,$item['clientUsername'],1,0,'L');
                $this->Cell(30,10,$item['clientName'],1,0,'L');
                $this->Cell(20,10,$item['status'],1,0,'L');
                $this->Cell(45,10,$item['description'],1,0,'L');
                $this->Cell(20,10,$item['department'],1,0,'L');
                $this->Cell(35,10,$item['loggedby'],1,0,'L');
                $this->Cell(35,10,$item['createdate'],1,0,'L');
                $this->Cell(20,10,$item['lat'],1,0,'L');
                $this->Cell(20,10,$item['lon'],1,0,'L'); 
            }

        }catch(PDOException $er)
        {
            echo $er->getMessage();
        }   
    }
    
    function headerTable()
    { 
        date_default_timezone_set('Africa/Johannesburg');
        $date = new DateTime();
        $this->SetFont('Arial','B',10);
        $this->Cell(20,10,'Ticket ID',1,0,'C');
        $this->Cell(30,10,'Client Email',1,0,'C');
        $this->Cell(30,10,'Client Name',1,0,'C');
        $this->Cell(20,10,'Status',1,0,'C');
        $this->Cell(45,10,'Description',1,0,'C');
        $this->Cell(20,10,'department',1,0,'C');
        $this->Cell(35,10,'Logged by',1,0,'C');
        $this->Cell(35,10,'createdate',1,0,'C');
        $this->Cell(20,10,'Latitude',1,0,'C');
        $this->Cell(20,10,'Longitude',1,0,'C');
        $this->getBookingsStandings();
        $this->ln();
        $this->ln();
    }
}
?>