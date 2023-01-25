<?php
require_once('MyClasses/printFile.php');
try{
    if(isset($_SESSION['auth']) && $_SESSION['auth']==true)
    {    
        $caption="Ticket System records Report";
        $pdf=new myPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('l','A4',0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Image('img/good.png',5,5,40);
        $pdf->cell(188,5,$caption,0,1,'C');
        $pdf->spaceby_Y(9);
        $pdf->headerTable();
        $pdf->Output('D','TicketSystem.pdf');
    }
    else{?>
    h3 style="background-color: red;">Error:Unable to access this file.</h3><br>
    <h4>Prohibited atempt to print file detected</h4> 

   <?php }
    

    }catch(Exception $th){
        echo $th->getMessage();
    }
?>