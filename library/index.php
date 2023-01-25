<?php
        require('./library/fpdf.php');
        class myPDF extends FPDF{

            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial','',8);
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            }

            function LineBreak()
            {
              $this->Ln();
              $this->Ln();
            }
            
            function setTextNoborder($width,$height,$caption,$alignment)
            {
              $this->cell($width,$height,$caption,0,1,$alignment);
            }

            function multilineBox($width,$height,$rowcount,$alignment)
              {
                  for ($x = 0; $x < $rowcount; $x++) {
                    if($rowcount-$x==1)
                    {
                      $this->cell($width,$height,'',1,0,$alignment);
                    }
                    else
                    {
                      $this->cell($width,$height,'',1,1,$alignment);
                    }
                  
                }

              }

              function setPart($caption,$width,$height,$alignment)
              {
                  $this->cell(68,6,'',0,1,'L');
                  $this->cell($width,$height,'PART '.$caption,0,1,$alignment);
                  $this->cell(68,3,'',0,1,'L');
              }

              function signBox($firstColwidth,$secColWidth,$height,$captionOne,$captiontwo,$alignment,$colorfirstCol,$colorSecCol)
              {

                $this->cell($firstColwidth,$height,' '.$captionOne,1,0,$alignment,$colorfirstCol);
                $this->cell($secColWidth,$height,' '.$captiontwo,1,0,$alignment,$colorSecCol);

              }

            function twoColOneline($firstColwidth,$secColWidth,$height,$caption,$numbering,$alignment,$colorfirstCol,$colorSecCol)
            {
              if($colorfirstCol==1 && $colorSecCol==0)
              {
                $this->cell(188,3,'',0,1,$alignment);
                $this->cell(188,5,'',0,1,'L');
                $this->cell($firstColwidth,$height,$numbering.' '.$caption,1,0,$alignment,1);
                $this->cell($secColWidth,$height,'',1,1,$alignment);
                
              }
              

              if($colorfirstCol==0 && $colorSecCol==1)
              {
                $this->cell(188,5,'',0,1,$alignment);
                $this->cell(188,5,'',0,1,'L');
                $this->cell($firstColwidth,$height,$numbering.' '.$caption,1,0,$alignment);
                $this->cell($secColWidth,$height,'',1,1,$alignment,1);
              }
              if($colorfirstCol==1 && $colorSecCol==1) //color both
              {
                $this->cell(188,5,'',0,1,$alignment);
                $this->cell(188,5,'',0,1,'L');
                $this->cell($firstColwidth,$height,$numbering.' '.$caption,1,0,$alignment,1);
                $this->cell($secColWidth,$height,'',1,1,$alignment,1);
              }

            }
            

            function spaceNheadingCaption($width,$height,$caption,$isbordered,$isnewLine,$alignment,$isColored,$numbering)
            {
              if($isbordered==1 && $isnewLine==1)
              {

                $this->cell($width,$height,'',0,$isnewLine,$alignment);
                $this->cell($width,$height,$numbering.' '.$caption,1,$isnewLine,$alignment,$isColored);
                $this->cell(188,6,'',0,1,$alignment);

              }else if($isbordered==0 && $isnewLine==0)
              {
                $this->cell($width,$height,'',0,$isnewLine,$alignment);
                $this->cell($width,$height,$numbering.' '.$caption,1,1,$alignment,$isColored);

              }
              
            }

            function tableheading($dataArray,$width,$height,$alignment)
            {
              //heading
              for($i=0;$i<sizeof($dataArray);$i++)
              {
                $this->Cell($width,$height,$dataArray[$i],1,0,$alignment);
                if((sizeof($dataArray)-$i)==2)
                {
                  $this->Cell($width,$height,$dataArray[$i+1],1,1,$alignment);
                  $i=sizeof($dataArray);
                }
                
              }

            }

            
            function tablebody($width,$height,$dataArray,$rowcount,$alignment)
            {
              for($rows=0;$rows<$rowcount;$rows++)
              {
                for($i=0;$i<sizeof($dataArray);$i++)
                {
                  $this->Cell($width,$height,'',1,0,$alignment);
                  if((sizeof($dataArray)-$i)==2)
                  {
                    $this->Cell($width,$height,'',1,1,$alignment);
                    $i=sizeof($dataArray);
                  }
                  
                }

              }

            }

            function tableSideHeading($firstColWidth,$secColWidth,$height,$dataArray,$alignment)
            {
              for($i=0;$i<sizeof($dataArray);$i++)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'',1,1,$alignment);

                }
            }

            function complexTableOne($firstColWidth,$secColWidth,$thirdColWidth,$height,$dataArray,$alignment){
              for($i=0;$i<sizeof($dataArray);$i++)
              {
                if($i==0)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'%',1,1,$alignment);
                }
                if($i==1)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'',1,0,$alignment);
                  $this->cell($thirdColWidth,$height,'Term:',1,1,$alignment);
                }
                if($i==2)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'',1,1,$alignment);
                  
                }
                if($i==3)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'',1,0,$alignment);
                  $this->cell($thirdColWidth,$height,'Date:',1,1,$alignment);
                  
                }
                if($i==4)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'',1,1,$alignment);
                  
                }
                if($i==5)
                {
                  $this->Cell($firstColWidth,$height,$dataArray[$i],1,0,$alignment);
                  $this->cell($secColWidth,$height,'',1,1,$alignment);
                  
                }
              }

            }

            function complexTableTwo($dataArray)
            {
              $elementsleft=0;
              for($i=0;$i<sizeof($dataArray);$i++)
              {
                if($i==0)
                {
                  $this->Cell(50,5,'',1,0,'L');
                  $this->cell(50,5,'Rand',1,0,'L',1);
                  $this->cell(50,5,'Loan term',1,1,'L',1);
                }
                if($i==1)
                {
                  $this->Cell(50,5,$dataArray[$i],1,0,'L');
                  $this->cell(50,15,'',1,0,'L');
                  $this->cell(50,5,'',1,1,'L');
                  $elementsleft=4;
                }

              }
              for($e=2;$e<($elementsleft+2);$e++)
              {
                if($e!=2 && $e!=3)
                {
                  $this->cell(50,5,$dataArray[$e],1,0,'L');
                  $this->cell(50,5,'',1,1,'L');
                }
                else{
                  $this->cell(50,5,$dataArray[$e],1,1,'L');
                }
                

              }


            }
            function spaceby_Y($moveby)
            {
              for ($x = 0; $x <= 3; $x++) {
                $this->cell(180,$moveby,'',0,1,'C');
              }
            }



        }//class end

        $pdf=new myPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('p','A4',0);
        $pdf->SetFont('Arial','B',9);
        

        $pdf->setPart('B',180,6,'C');

        $pdf->Linebreak();
        $pdf->setTextNoborder(188,5,'For Office Use','L');
        $pdf->Ln();
        $pdf->signBox(94,94,5,'Captured by: ','','L',0,0);
        $pdf->Ln();
        $pdf->signBox(94,94,15,'Signed','Date','L',0,0);

        $pdf->Linebreak();
        $pdf->setTextNoborder(188,5,'Confidential report by interviewing officer on applicant and / or business:','L');
        $pdf->multilineBox(188,6,12,'L');
        $pdf->Ln();
        $pdf->signBox(94,94,15,'Signed','Date','L',0,0);
        $pdf->LineBreak();
        $pdf->signBox(94,94,5,'Account No:','10. Credit account created','L',0,0);
        $pdf->LineBreak();

        $completableArray= array("Interest rate","Account type selected",
        "Amount applied for","Loan granted","Loan start date","first instalment date");
        $pdf->complexTableOne(78,50,50,5,$completableArray,'L');
        $pdf->Ln();
        $AccountTab= array("Usage","indicator","industry sector","Region","Instalment per contract calculated");
        $pdf->spaceNheadingCaption(68,6,'Account tab',1,1,'L',0,'11.');
        //the arays content are the same as of 4.
        $pdf->tableSideHeading(68,120,6,$AccountTab,'L');

        $detailTab= array("Instalment payment","Loan officer/agent",
        "Loans funder","Debt collector","Attorney","Staff member","Group entity","Guarantor","GL Company");
        $pdf->spaceNheadingCaption(68,6,'Details tab',1,1,'L',0,'12.');
        //the arays content are the same as of 4.
        $pdf->tableSideHeading(68,120,6,$detailTab,'L');

        $pdf->spaceNheadingCaption(68,6,'Loan repayment',1,1,'L',0,'13.');

        //complex table here 
        $pdf->Ln();
        $arayComplexTwo=array("","Monthly instalment","Credit life cover","Monthly service fee","Total monthly amount due","Rounded off");
        $pdf->complexTableTwo($arayComplexTwo);
        //
        $pdf->Ln();
        $pdf->spaceNheadingCaption(68,6,'Conclusion',1,1,'L',0,'14.');

        $pdf->Ln();
        $pdf->setTextNoborder(188,5,'Loan Officer:','L');
        $pdf->signBox(94,94,15,'Signed','Date','L',0,0);
        $pdf->Ln();
        $pdf->setTextNoborder(188,5,'Manager: loan proposal and origination','L');
        $pdf->signBox(94,94,15,'Signed','Date','L',0,0);
        $pdf->Output();


?>