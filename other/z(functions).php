<?php
/*
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

    include('dbconn.php');
    require('../fpdf181/fpdf.php');
    session_start();

    $GLOBALawardeenumber = $_SESSION['awardeenumber'];

//Login
if(isset($_POST['btn_login'])){

    $awardeenum = $_POST['awardeenum'];
    $password = $_POST['password'];

    if(empty($awardeenum) || empty($password)){
        header('location: ../index.php?login=empty');
    }
    else{
        $sql = "SELECT * FROM tbl_pnsl_grantees WHERE award_no ='$awardeenum' AND password = '$password';";
        $results = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($results);

        if($resultCheck > 0){
            $_SESSION['awardeenumber'] = $awardeenum;
            
            header("location: ../instructions.php");      
        }
        else{
            header("location: ../index.php?login=notmatched");
        }
    }

    
}



//Save changes

if(isset($_POST['btn_save'])){ 

    $sqlfind = "SELECT award_no FROM tbl_lbp_form WHERE award_no = '$GLOBALawardeenumber'";
    $res = mysqli_query($conn, $sqlfind);
    $resCheck = mysqli_num_rows($res);

    if ($resCheck == 0){
        // INSERT Code if Info is not updated
        $sqlSelectapp_id = "SELECT app_id FROM tbl_pnsl_grantees WHERE award_no = '$GLOBALawardeenumber'";
        $app_idres = mysqli_query($conn, $sqlSelectapp_id);
        $app_idresCheck = mysqli_num_rows($app_idres);

        while($row = mysqli_fetch_assoc($app_idres)){
            if ($app_idresCheck == 1){
                $app_id = $row['app_id'];                
                
                $pobirth = $_POST['txt_placeofbirth'];
                $nationality = $_POST['txt_nationality'];
                $mobile = $_POST['txt_mobile'];
                $email = $_POST['txt_email'];
                $perbrgy = $_POST['txt_perbrgy'];
                $prestreet = $_POST['txt_prestreet'];
                $prebrgy = $_POST['txt_prebrgy'];
                $precity = $_POST['txt_precity'];
                $preprovince = $_POST['txt_preprovince']; 
                $prezip = $_POST['txt_prezip'];       
                $branches = $_POST['dd_branches'];

                $sqlInsert = "INSERT INTO tbl_lbp_form (app_id, award_no, birth_place, nationality, permanent_barangay, present_street, present_barangay,present_city, present_province, present_zip, contact, email, lbp_branch) VALUES ('$app_id','$GLOBALawardeenumber','$pobirth','$nationality','$perbrgy','$prestreet','$prebrgy','$precity','$preprovince','$prezip','$mobile','$email','$branches')";
                mysqli_query($conn, $sqlInsert);
                header("location: ../forms.php");
            }
        }        
    }
    elseif($resCheck == 1){
        // UPDATE Code if Info is updated        
        $pobirth = $_POST['txt_placeofbirth'];
        $nationality = $_POST['txt_nationality'];
        $mobile = $_POST['txt_mobile'];
        $email = $_POST['txt_email'];
        $perbrgy = $_POST['txt_perbrgy'];
        $prestreet = $_POST['txt_prestreet'];
        $prebrgy = $_POST['txt_prebrgy'];
        $precity = $_POST['txt_precity'];
        $preprovince = $_POST['txt_preprovince']; 
        $prezip = $_POST['txt_prezip'];       
        $branches = $_POST['dd_branches'];

        $sql = "UPDATE tbl_lbp_form set 
        lbp_branch = '$branches',
        birth_place = '$pobirth',
        nationality = '$nationality',
        permanent_barangay = '$perbrgy',
        present_street = '$prestreet',
        present_barangay = '$prebrgy',
        present_city = '$precity',
        present_province = '$preprovince',
        present_zip = '$prezip',
        contact = '$mobile',
        email = '$email'
        WHERE award_no = '$GLOBALawardeenumber'";
        mysqli_query($conn, $sql);
        
        header("location: ../forms.php");
        
    }
}

    
      
        
   
    
    
//export form
    if(isset($_POST['btn_export'])){        
        
        $branches = str_replace("Ã±","n", $_POST['dd_branches']);
        $fname = str_replace("Ã±","n", $_POST['txt_firstname']);
        $mname = str_replace("Ã±","n", $_POST['txt_middlename']);
        $lname = str_replace("Ã±","n", $_POST['txt_lastname']);
        $gender = str_replace("Ã±","n", $_POST['txt_gender']);
        $dobirth = str_replace("Ã±","n", $_POST['txt_dateofbirth']);
        $pobirth = str_replace("Ã±","n", $_POST['txt_placeofbirth']);
        $nationality = str_replace("Ã±","n", $_POST['txt_nationality']);
        $mothermaiden = str_replace("Ã±","n", $_POST['txt_mothername']);
        $hei = str_replace("Ã±","n", $_POST['txt_hei']);
        $mobile = str_replace("Ã±","n", $_POST['txt_mobile']);
        $email = str_replace("Ã±","n", $_POST['txt_email']);
        $perstreet = str_replace("Ã±","n", $_POST['txt_perstreet']);
        $perbrgy = str_replace("Ã±","n", $_POST['txt_perbrgy']);
        $percity = str_replace("Ã±","n", $_POST['txt_percity']);
        $perprovince = str_replace("Ã±","n", $_POST['txt_perprovince']);
        $perzip = str_replace("Ã±","n", $_POST['txt_perzip']);
        $prestreet = str_replace("Ã±","n", $_POST['txt_prestreet']);
        $prebrgy = str_replace("Ã±","n", $_POST['txt_prebrgy']);
        $precity = str_replace("Ã±","n", $_POST['txt_precity']);
        $preprovince = str_replace("Ã±","n", $_POST['txt_preprovince']);
        $prezip = str_replace("Ã±","n", $_POST['txt_prezip']);
        $day = date('m/d/y');
        

        $studentFullName = $fname." ".$mname." ".$lname;
        $studentFullName2 = str_replace("Ã±","n",$studentFullName);
        $str = utf8_decode($fullNameUpper = strtoupper($studentFullName2));
        $i = strlen($fullNameUpper);
        $arr1 = str_split($fullNameUpper);
        
        
           
        $pdf = new FPDF('p','mm', 'A4');
        $pdf->AddPage();

         
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image('../image/LandbankLogo.png',11,9,8,8);
        $pdf->Cell(10 ,-2 ,'',0,0);
        $pdf->Cell(158 ,4 ,'LAND BANK OF THE PHILIPPINES',0,0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(27 ,4 ,'ANNEX A',0,1);

        $leftPosition = 20;
        foreach($arr1 as $i => $r){
            if($arr1[$i] == " "){
                $pdf->Image('../image/letters/space.png',$leftPosition,152.7,5,5);
            }
            elseif($arr1[$i] == "Ã±"){
                $pdf->Image('../image/letters/Enye.png',$leftPosition,152.7,5,5);
            }
            else{
                $pdf->Image('../image/letters/'.$arr1[$i].'.png',$leftPosition,152.7,5,5);     
            }
            $leftPosition=$leftPosition+7.65;        
        }

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(10 ,4 ,'',0,0);
        $pdf->Cell(175 ,4 ,'Branch   '.$branches,0,1);
        $pdf->Image('../image/Line.png',30,-7.4,50,50);
        $pdf->Cell(185 ,2 ,'',0,1, 'C');

        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(190 ,2 ,'LANDBANK CASH CARD/PREPAID CARD ENROLLMENT FORM',0,1,'C');
        
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(145 ,4 ,' ',0,0);
        $pdf->Cell(55 ,7 ,'Date:        '.$day,0,1,'L');
        $pdf->Image('../image/Line.png',163,2,38,50);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(190 ,3 ,'Please check the type of card being enrolled: ',1,1,'L');
        
        $pdf->SetFont('Arial', '', 8);
        $pdf->Image('../image/CashCard.png',15,23,36,36);
        $pdf->Image('../image/check.png',17.8,30.5,6,6);
        $pdf->Image('../image/check.png',25,34,6,6);
        $pdf->Cell(45 ,15 ,'' ,1,0,'L');
        $pdf->Image('../image/PrepaidCard.png',80,24.6,89,36);
        $pdf->Image('../image/Select.png',110,31,86,9);
        $pdf->Cell(145 ,15 ,'',1,1,'L');

        $pdf->SetFont('Arial','B', 8);
        $pdf->Cell(190,3,"Purchaser's Information",1,1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(115,3,"Purchaser's Name: " ,'L',0, 'L');
        $pdf->Cell(75,3,"With existing account with LBP " ,'LR',1, 'L');

        $pdf->Image('../image/YesNo.png',173 ,47.5,20,8);
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(115,3,$studentFullName2 ,'L',0, 'C');
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(75,3,"if yes, pls specify Acct. No/s:" ,'LR',1, 'L');

        $pdf->Image('../image/Line.png',167 ,30.5,34,50);
        $pdf->Image('../image/check.png',187.5,46,6,6);
        $pdf->Cell(115,3,'' ,'L',0, 'C');
        $pdf->Cell(75,3,"Cash Card Number/s:" ,'LBR',1, 'L');

        $pdf->Image('../image/Line.png',167 ,34,34,50);

        $pdf->SetFont('Arial','B', 8);
        $pdf->Cell(190,4,"ADDITIONAL INFORMATION FOR WALK-INVINDIVIDUAL PURCHASER, AND CARDHOLDER OF INSTITUTIONAL PURCHASER:" ,1,1, 'L');
        
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(159,3,"Cardholder's Name:" ,'LR',0, 'L');
        $pdf->Cell(31,3,"Gender:" ,'LR',1, 'L');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(159,3,$studentFullName2,'LR',0, 'C');
        $pdf->Cell(31,3,$gender ,'LR',1, 'C');
        $pdf->Cell(159,3,"" ,'LBR',0, 'L');
        $pdf->Cell(31,3,"" ,'LBR',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(141,3,"Permanent Address:" ,'LR',0, 'L');
        $pdf->Cell(18,3,"Zip Code:" ,'LR',0, 'L');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(141,3,$perstreet.', '.$perbrgy.',','LR',0, 'C');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(18,3,$perzip ,'LR',0, 'C');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(141,3,$percity.', '.$perprovince  ,'LBR',0, 'C');
        $pdf->Cell(18,3,"" ,'LBR',0, 'L');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(141,3,"Present Address:" ,'LR',0, 'L');
        $pdf->Cell(18,3,"Zip Code:" ,'LR',0, 'L');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(141,3,$prestreet.', '.$prebrgy.',','LR',0, 'C');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(18,3,$prezip ,'LR',0, 'C');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(141,3,$precity.', '.$preprovince  ,'LBR',0, 'C');
        $pdf->Cell(18,3,"" ,'LBR',0, 'L');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');
        
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(46,3,"Place of Birth:" ,'LR',0, 'L');
        $pdf->Cell(49,3,"Date of Birth:" ,'LR',0, 'L');
        $pdf->Cell(27.75,3,"Nationality:" ,'LR',0, 'L');
        $pdf->Cell(36.25,3,"Mother's Maiden Name:" ,'LR',0, 'L');
        $pdf->Cell(31,3,"" ,'LR',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(46,3,$pobirth ,'LR',0, 'C');
        $pdf->Cell(49,3,$dobirth ,'LR',0, 'C');
        $pdf->Cell(27.75,3,$nationality ,'LR',0, 'C');
        $pdf->Cell(36.25,3,$mothermaiden ,'LR',0, 'C');
        $pdf->Cell(31,3,"" ,'LR',1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(46,3,"" ,'LBR',0, 'L');
        $pdf->Cell(49,3,"" ,'LBR',0, 'L');
        $pdf->Cell(27.75,3,"" ,'LBR',0, 'L');
        $pdf->Cell(36.25,3,"" ,'LBR',0, 'L');
        $pdf->Cell(31,3,"" ,'LBR',1, 'L');

        $pdf->Image('../image/box.png',169.5,70.25,30,30);
        
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(46,3,"Type of ID Presented:" ,'LR',0, 'L');
        $pdf->Cell(49,3,"ID Number Presented:" ,'LR',0, 'L');
        $pdf->Cell(27.75,3,"Profession:" ,'LR',0, 'L');
        $pdf->Cell(36.25,3,"Source of Fund:" ,'LR',0, 'L');
        $pdf->Cell(31,3,"TIN:" ,'LR',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(46,3,"N/A" ,'LR',0, 'C');
        $pdf->Cell(49,3,"N/A" ,'LR',0, 'C');
        $pdf->Cell(27.75,3,"N/A" ,'LR',0, 'C');
        $pdf->Cell(36.25,3,"N/A" ,'LR',0, 'C');
        $pdf->Cell(31,3,"N/A" ,'LR',1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(46,3,"" ,'LBR',0, 'L');
        $pdf->Cell(49,3,"" ,'LBR',0, 'L');
        $pdf->Cell(27.75,3,"" ,'LBR',0, 'L');
        $pdf->Cell(36.25,3,"" ,'LBR',0, 'L');
        $pdf->Cell(31,3,"" ,'LBR',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(95,3,"Name of Employer/Company/Business/School:" ,'LR',0, 'L');
        $pdf->Cell(64,3,"Contact Number/s: (home/office/mobile):" ,'LR',0, 'L');
        $pdf->Cell(31,3,"Gross Salary:" ,'LR',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(95,3,$hei ,'LR',0, 'C');
        $pdf->Cell(64,3,$mobile ,'LR',0, 'C');
        $pdf->Cell(31,3,"N/A" ,'LR',1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(95,3,"" ,'LBR',0, 'L');
        $pdf->Cell(64,3,"" ,'LBR',0, 'L');
        $pdf->Cell(31,3,"" ,'LBR',1, 'L');
        
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(190,4,"Gift Card Holder's Information" ,1,1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(89,3,"Cardholder's Name:" ,'LR',0, 'L');
        $pdf->Cell(46,3,"Contact Number/s:" ,'R',0, 'L');
        $pdf->Cell(55,3,"Date of Birth:" ,'LR',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(89,3,"N/A",'LR',0, 'C');
        $pdf->Cell(46,3,"N/A" ,'R',0, 'C');
        $pdf->Cell(55,3,"N/A" ,'R',1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(89,3,"" ,'LBR',0, 'L');
        $pdf->Cell(46,3,"" ,'BR',0, 'L');
        $pdf->Cell(55,3,"" ,'BR',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(135,3,"Permanent Address:" ,'LR',0, 'L');
        $pdf->Cell(27.5,3,"Zip Code:" ,'R',0, 'L');
        $pdf->Cell(27.5,3,"Relationship with:" ,'LR',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(135,3,"N/A",'LR',0, 'C');
        $pdf->Cell(27.5,3,"N/A" ,'R',0, 'C');
        $pdf->SetFont('Arial','', 9);
        $pdf->Cell(27.5,3,"the Purchaser" ,'R',1, 'L');

        $pdf->Cell(135,3,"" ,'LBR',0, 'L');
        $pdf->Cell(27.5,3,"" ,'BR',0, 'L');
        $pdf->Cell(27.5,3,"" ,'R',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(135,3,"Present Address:" ,'LR',0, 'L');
        $pdf->Cell(27.5,3,"Zip Code:" ,'R',0, 'L');
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(27.5,3,"N/A" ,'LR',1, 'C');

        
        $pdf->Cell(135,3,"N/A",'LR',0, 'C');
        $pdf->Cell(27.5,3,"N/A" ,'R',0, 'C');
        $pdf->SetFont('Arial','', 9);
        $pdf->Cell(27.5,3,"" ,'R',1, 'C');

        $pdf->Cell(135,3,"" ,'LBR',0, 'L');
        $pdf->Cell(27.5,3,"" ,'BR',0, 'L');
        $pdf->Cell(27.5,3,"" ,'BR',1, 'L');
        
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(190,3,"Name to Appear on the Card (maximum of 22 characters):" ,'LR',1, 'L');
        $pdf->Image('../image/boxes.png',3,150.5,195,9);
        $pdf->Cell(190,4,"" ,'LR',1, 'L');
        $pdf->Cell(190,4,"" ,'LBR',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(95,3,"Amount of Fee/Charges to be paid:" ,'LR',0, 'L');
        $pdf->Cell(50,3,"Mode of Payment:" ,0,0, 'L');
        $pdf->Cell(45,3,"" ,'R',1, 'L');

        
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(95,1,"",'LR',0, 'C');
        $pdf->Cell(50,1,"" ,0,0, 'C');
        $pdf->Cell(45,1,"" ,'R',1, 'C');
        
        $pdf->Cell(95,3,"",'LR',0, 'C');
        $pdf->Cell(50,3,"" ,0,0, 'C');
        $pdf->Cell(45,3,"" ,'R',1, 'C');

        $pdf->Cell(95,3,"P                                                           ",'LR',0, 'C');
        $pdf->Cell(50,3,"" ,0,0, 'C');
        $pdf->Cell(45,3,"" ,'R',1, 'C');
        $pdf->Image('../image/line.png',25,144.5,70,50);
        $pdf->Image('../image/CashDebit.png',125,163,60,6);
        $pdf->Image('../image/check.png',157,160.4,6,6);
        $pdf->Image('../image/Line.png',168,146.8,30,50);
        
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(95,3,"(Initial Cost of the Card)",'LR',0, 'C');
        $pdf->Cell(50,3,"" ,0,0, 'C');
        $pdf->Cell(45,3,"Acct. No." ,'R',1, 'L');        

        $pdf->Cell(95,3,"" ,'LBR',0, 'L');
        $pdf->Cell(50,3,"" ,'B',0, 'C');
        $pdf->Cell(45,3,"" ,'BR',1, 'L');
       
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(95,3,"I/We hereby certify that the above information is true and correct:" ,'L',0, 'L');
        $pdf->Cell(95,3,"" ,'R',1, 'L');
        
        $pdf->Cell(95,3,"",'L',0, 'C');
        $pdf->Cell(95,3,"" ,'R',1, 'C');
        
        $pdf->Cell(95,3,"",'L',0, 'C');
        $pdf->Cell(95,3,"" ,'R',1, 'C');

        $pdf->Cell(95,3,"",'L',0, 'C');
        $pdf->Cell(95,3,"" ,'R',1, 'C');

        $pdf->Image('../image/Line.png',28,162,60,50);
        $pdf->Image('../image/Line.png',122.5,162,60,50);

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(95,3,"Signature Over Printed Name",'L',0, 'C');
        $pdf->Cell(95,3,"Signature Over Printed Name" ,'R',1, 'C');   
        
        $pdf->Cell(95,3,"of Purchaser/Applicant/Authorized Signatory",'L',0, 'C');
        $pdf->Cell(95,3,"of Purchaser/Applicant/Authorized Signatory" ,'R',1, 'C');

        $pdf->Cell(95,1,"" ,'LB',0, 'C');
        $pdf->Cell(95,1,"" ,'BR',1, 'L');

        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(190, 5, "FOR BANK'S USE ONLY", 1,1,"C");

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(63.33,3,"Processed by:" ,'LR',0, 'L');
        $pdf->Cell(63.33,3,"Checked by:" ,'R',0, 'L');
        $pdf->Cell(63.33,3,"Approved by:" ,'R',1, 'L');
        
        $pdf->Cell(63.33,3,"" ,'LR',0, 'C');
        $pdf->Cell(63.33,3,"" ,'R',0, 'C');
        $pdf->Cell(63.33,3,"" ,'R',1, 'C');
        
        $pdf->Cell(63.33,3,"" ,'LR',0, 'C');
        $pdf->Cell(63.33,3,"" ,'R',0, 'C');
        $pdf->Cell(63.33,3,"" ,'R',1, 'C');

        $pdf->Image('../image/Line.png',9,183.4,67,50);
        $pdf->Image('../image/Line.png',72.2,183.4,67,50);
        $pdf->Image('../image/Line.png',135.4,183.4,67,50);

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(63.33,3,"Customer Associate/NAC" ,'LR',0, 'C');
        $pdf->Cell(63.33,3,"BOO/BSO" ,'R',0, 'C');
        $pdf->Cell(63.33,3,"Branch Head" ,'R',1, 'C');  
        
        $pdf->Cell(63.33,1.5,"" ,'LR',0, 'C');
        $pdf->Cell(63.33,1.5,"" ,'R',0, 'C');
        $pdf->Cell(63.33,1.5,"" ,'R',1, 'C');
        
        $pdf->Cell(63.33,2,"Date/Time: ___________________" ,'LR',0, 'C');
        $pdf->Cell(63.33,2,"Date: ___________________" ,'R',0, 'C');
        $pdf->Cell(63.33,2,"Date: ___________________" ,'R',1, 'C');

        $pdf->Cell(63.33,1,"" ,'LBR',0, 'C');
        $pdf->Cell(63.33,1,"" ,'BR',0, 'C');
        $pdf->Cell(63.33,1,"" ,'BR',1, 'C');

        $pdf->SetFont('Arial','', 7);
        $pdf->Cell(190,4,"for Branches without BOO" ,0,1, 'L');
        $pdf->Image('../image/cut.png',5, 204.5, 200, 30);
        $pdf->Cell(190,3,"Validation Print (if paid through cash):" ,0,1, 'L');
      
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(190,4,"" ,0,1, 'C');
        $pdf->Cell(190, 5, "CASH CARD/PREPAID CARD/PIN MAILER CLAIM STUB", 1,1,"C");

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(47.5,3,"Card Number:" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"Card Holder's Name:" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"Purchaser's Name:" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"Date:" ,'R',1, 'L');


        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(47.5,3,"" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(47.5,3,"" ,'LBR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'BR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'BR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'BR',1, 'L');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(47.5,3,"Prepaid Card Released by:" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"PIN Haller Released by:" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"Approved for Release:" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"Card/PIN Mailer Recieved by:" ,'R',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(47.5,3,"" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(47.5,3,"" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',1, 'L');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(47.5,3,"" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',1, 'L');

        $pdf->Image('../image/Line.png',9,228,50,50);
        $pdf->Image('../image/Line.png',56.5,228,50,50);
        $pdf->Image('../image/Line.png',104,228,50,50);
        $pdf->Image('../image/Line.png',151.5,228,50,50);

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(47.5,3,"Card Custodian" ,'LR',0, 'C');
        $pdf->Cell(47.5,3,"PIN Mailer Custodian" ,'R',0, 'C');
        $pdf->Cell(47.5,3,"Branch Head/BOO/BSO" ,'R',0, 'C');
        $pdf->Cell(47.5,3,"Signature Over Printed Name" ,'R',1, 'C');

        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(47.5,3,"" ,'LR',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"" ,'R',0, 'L');
        $pdf->Cell(47.5,3,"of Purchaser/Cardholder" ,'R',1, 'C');

        $pdf->Cell(47.5,2,"Date/Time: ___________________" ,'LR',0, 'L');
        $pdf->Cell(47.5,2,"Date/Time: ___________________" ,'R',0, 'L');
        $pdf->Cell(47.5,2,"" ,'R',0, 'L');
        $pdf->Cell(47.5,2,"" ,'R',1, 'C');

        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(47.5,1,"" ,'LBR',0, 'L');
        $pdf->Cell(47.5,1,"" ,'BR',0, 'L');
        $pdf->Cell(47.5,1,"" ,'BR',0, 'L');
        $pdf->Cell(47.5,1,"" ,'BR',1, 'L');

        $pdf->SetFont('Arial','', 7);
        $pdf->Cell(190,3,"Reminder/s:" ,'LR',1, 'L');
        $pdf->Cell(190,3,"- You may claim your Prepaid Card after 7 banking days for Metro Manila Branches, and 15 banking days for Provincial Branches, and a replacement fee shall be collected" ,'LR',1, 'L');
        $pdf->Cell(190,3,"- Unclaimed Prepaid Card/PIN Mailer shall be perforated after 120 calendar days (for CCT)/30 calendar days (regular) from issuance/re-issuance" ,'LR',1, 'L');
        $pdf->Cell(190,3,"- Please sign your Prepaid Card immediately" ,'LBR',1, 'L');

        $pdf->Cell(95,3,"Validation Print (if debted from deposit account):" ,0,0, 'L');
        $pdf->Cell(95,3,"Revised 03092018" ,0,1, 'R');

        $pdf->output('I', $studentFullName2.' - LandBank Form ('.$day.')');    
           
    }
//Send Email to UniFAST
    if(isset($_POST['btn_send'])){

        require 'PHPMailer/vendor/autoload.php';  

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
        //Server settings
        $mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'jbahil49@gmail.com';                 // SMTP username
        $mail->Password = 'tes123tes123';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('jbahil49@gmail.com', 'Jason');
        $mail->addAddress('jbahil47@gmail.com');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
        } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }
    */
?>