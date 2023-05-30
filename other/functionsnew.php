<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

    include('dbconnect.php');
    header("Content-Type:text/html; charset=ISO-8859-1");
    require('../fpdf181/fpdf.php');
    session_start();

    $GLOBALawardeenumber = $_SESSION['awardeenumber'];

    $ACADEMIC_YEAR = "2018-2019";
    $msglogin = "";
    $msg = "";

//Login
if(isset($_POST['btn_login'])){

    $awardeenum = mysqli_real_escape_string($conn, $_POST['awardeenum']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // $awardeenum = $_POST['awardeenum'];
    // $password = $_POST['password'];

    if(empty($awardeenum) || empty($password)){
        $msglogin = "Awardee Number and Password is required";
        header('location: ../index.php?emptylogin='.$msglogin);
    }
    else{
        $sql = "SELECT * FROM vw_complete_teslbp_data WHERE award_no ='$awardeenum' AND password = '$password' AND ac_year = '$ACADEMIC_YEAR'";
        $results = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($results);

        if($resultCheck > 0){
            $_SESSION['awardeenumber'] = $awardeenum;
            while($row = mysqli_fetch_assoc($results)){
                $privacy_agreement = mysqli_real_escape_string($conn, $row['privacy_agreement']);
            }
            
            if($privacy_agreement == 'YES'){
                header("location: ../instructions.php");  
            }
            elseif($privacy_agreement == 'NO' || $privacy_agreement == '' || $privacy_agreement == NULL){
                header('location: ../privacyagreement.php');
            }
                
        }
        else{
            $msglogin = "Awardee Number and Password is did not matched";
            header("location: ../index.php?notmatchedlogin=".$msglogin);
        }
    }

    
}

//Pricacy Terms
if(isset($_POST['btn_agree'])){
    $sqlUpdatePrivacyAgreement = "UPDATE tbl_lbp_form SET privacy_agreement = 'YES' WHERE award_no='".$GLOBALawardeenumber."'";
    mysqli_query($conn, $sqlUpdatePrivacyAgreement);
    header('location: ../instructions.php');
}
elseif(isset($_POST['btn_disagree'])){
    session_destroy();
    unset($_SESSION['awardeenumber']);
    header("location: ../index.php");
}


//Save changes


if(isset($_POST['btn_save'])){ 
   
    //SAVE STUDENT INFO
    $sqlfind = "SELECT award_no, photo FROM tbl_lbp_form WHERE award_no = '$GLOBALawardeenumber'";
    $res = mysqli_query($conn, $sqlfind);
    $resCheck = mysqli_num_rows($res);
    while($row = mysqli_fetch_assoc($res)){
        $existingPhoto = mysqli_real_escape_string($conn, $row['photo']);
    }
    

    if($resCheck == 1){
        // UPDATE tbl_lbp_form for additional grantee info   
        $sqlSelectBranch = "SELECT * FROM tbl_lbp_branches WHERE uid = ".$_POST['dd_branches']; 
        $resultsqlSelectBranch = mysqli_query($conn, $sqlSelectBranch); 
        $checksqlSelectBranch = mysqli_num_rows($resultsqlSelectBranch);
        if($checksqlSelectBranch > 0){
            while($row = mysqli_fetch_assoc($resultsqlSelectBranch)){
                $branchName = mysqli_real_escape_string($conn, $row['branch_name']);
            }
        }   
      
        $title = mysqli_real_escape_string($conn, $_POST['dd_title']);
        $marital_status = mysqli_real_escape_string($conn, $_POST['dd_marital_status']);
        $pobirth = mysqli_real_escape_string($conn, $_POST['txt_placeofbirth']);
        $nationality = mysqli_real_escape_string($conn, $_POST['txt_nationality']);
        $idnumber = mysqli_real_escape_string($conn, $_POST['txt_idnumber']);
        $idtype = mysqli_real_escape_string($conn, $_POST['dd_idtype']);
        $tin = mysqli_real_escape_string($conn, $_POST['txt_tin']);
        $profession = mysqli_real_escape_string($conn, $_POST['txt_profession']);
        $sourcefund_id = mysqli_real_escape_string($conn, $_POST['dd_sourceoffund']);
        $gross_salary_id = mysqli_real_escape_string($conn, $_POST['dd_salary']);
        $perbrgy = mysqli_real_escape_string($conn, $_POST['txt_perbrgy']);
        $prestreet = mysqli_real_escape_string($conn, $_POST['txt_prestreet']);
        $prebrgy = mysqli_real_escape_string($conn, $_POST['txt_prebrgy']);
        $precity = mysqli_real_escape_string($conn, $_POST['txt_precity']);
        $preprovince = mysqli_real_escape_string($conn, $_POST['txt_preprovince']); 
        $prezip = mysqli_real_escape_string($conn, $_POST['txt_prezip']); 
        $mobile = mysqli_real_escape_string($conn, $_POST['txt_mobile']);
        $email = mysqli_real_escape_string($conn, $_POST['txt_email']);
        $emboss = mysqli_real_escape_string($conn, $_POST['txt_emboss']);
        $u_photo = $_FILES['file_photo'];
        
        //SAVE IMAGE PATH
        // $u_photoName = $_FILES['file_photo']['name'];
        // $u_photoTmpName = $_FILES['file_photo']['tmp_name'];
        // $u_photoSize = $_FILES['file_photo']['size'];
        // $u_photoError = $_FILES['file_photo']['error'];
        // $u_photoType = $_FILES['file_photo']['type'];
        
        // $fileExt = explode('.', $u_photoName);
        // $fileActualExt = strtolower(end($fileExt));

        // $allowed = array('jpg', 'jpeg', 'png');

        // if(!$existingPhoto){
        //     echo "you have no exisiting photo";
        //     if($u_photoSize > 0){
        //         if(in_array($fileActualExt, $allowed)){
        //             if($u_photoError === 0){
        //                 if($u_photoSize < 2000000){
                            
    
        //                     $photoNewName = uniqid('', true).".".$fileActualExt;
        //                     $fileDestination = "../image/studentupload/".$GLOBALawardeenumber." - ".$photoNewName;
        //                     move_uploaded_file($u_photoTmpName, $fileDestination);
        //                 }
        //                 else{
        //                     $msg = "FILE UPLOAD ERROR: Your file is too big";
        //                     header('location: ../forms.php?errmsg='.$msg);
        //                     exit();
        //                 }
        //             }
        //             else{
        //                 $msg = "FILE UPLOAD ERROR: There was an error uploading your file";
        //                 header('location: ../forms.php?errmsg='.$msg);
        //                 exit();
        //             }
        //         }
        //         else{
        //             $msg = "FILE UPLOAD ERROR: Please select a valid file format for photo";
        //             header('location: ../forms.php?errmsg='.$msg);
        //             exit();
        //         }
        //     }
        //     else{
        //         $msg = "Please upload a photo to proceed";
        //         header('location: ../forms.php?errmsg='.$msg);
        //         exit();
                
        //     }
            
        // }
        // elseif($existingPhoto){ 
        //     echo "you have an existing photo";
        //     if($u_photoName){
        //         unlink($existingPhoto);//delete existing photo 
        //         if($u_photoSize > 0){
        //             if(in_array($fileActualExt, $allowed)){
        //                 if($u_photoError === 0){
        //                     if($u_photoSize < 2000000){
        //                         $photoNewName = uniqid('', true).".".$fileActualExt;
        //                         $fileDestination = "../image/studentupload/".$GLOBALawardeenumber." - ".$photoNewName;
        //                         move_uploaded_file($u_photoTmpName, $fileDestination);
        //                     }
        //                     else{
        //                         $msg = "FILE UPLOAD ERROR: Your file is too big";
        //                         header('location: ../forms.php?errmsg='.$msg);
        //                         exit();
        //                     }
        //                 }
        //                 else{
        //                     $msg = "FILE UPLOAD ERROR: There was an error uploading your file";
        //                     header('location: ../forms.php?errmsg='.$msg);
        //                     exit();
        //                 }
        //             }
        //             else{
        //                 $msg = "FILE UPLOAD ERROR: Please select a valid file format for photo";
        //                 header('location: ../forms.php?errmsg='.$msg);
        //                 exit();
        //             }
        //         }
        //         else{
        //             $msg = "Please upload a photo to proceed";
        //             header('location: ../forms.php?errmsg='.$msg);
        //             exit();
                    
        //         }
        //     }
        //     else{
        //         $fileDestination = $existingPhoto;
        //     }
            
        // }
         
        $sql = "UPDATE tbl_lbp_form set 
        lbp_branch = '$branchName', 
        birth_place = '$pobirth',
        title = '$title',
        marital_status = '$marital_status',
        nationality = '$nationality',
        id_number = '$idnumber',
        id_type = '$idtype',
        tin = '$tin',
        profession = '$profession',
        source_of_fund_id = '$sourcefund_id',
        gross_salary_id = '$gross_salary_id',
        permanent_barangay = '$perbrgy',
        present_street = '$prestreet',
        present_barangay = '$prebrgy',
        present_city = '$precity',
        present_province = '$preprovince',
        present_zip = '$prezip',
        contact = '$mobile',
        email = '$email',
        emboss_name = '$emboss'
        WHERE award_no = '$GLOBALawardeenumber'";
        
    
        mysqli_query($conn, $sql);

        if(mysqli_query($conn, $sql)){
            var_dump($sql);
            $msg = "Update Successful";
            header("location: ../forms.php?sucmsg=".$msg);
        }
        else{
            $msg = "Update Failed";
            header("location: ../forms.php?errmsg=".$msg);
        }
    }
   
}

    
//EXPORT FORM
if(isset($_POST['btn_export'])){        
    
    $sqlQuery = "SELECT * FROM vw_complete_teslbp_data WHERE award_no = '$GLOBALawardeenumber'";
    $result = mysqli_query($conn, $sqlQuery);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)){
        
        if ($resultCheck == 1){
            $db_app_id = mysqli_real_escape_string($conn, $row['app_id']);
            $db_award_no = mysqli_real_escape_string($conn, $row['award_no']);
            $db_ac_year = mysqli_real_escape_string($conn, $row['ac_year']);
            $db_lname = mysqli_real_escape_string($conn, $row['lname']);
            $db_fname = mysqli_real_escape_string($conn, $row['fname']);
            $db_mname = mysqli_real_escape_string($conn, $row['mname']);
            $db_sex = mysqli_real_escape_string($conn, $row['sex']);
            $db_title = mysqli_real_escape_string($conn, $row['title']);
            $db_marital_status = mysqli_real_escape_string($conn, $row['marital_status']);
            $db_birthdate = mysqli_real_escape_string($conn, $row['birthdate']);
            $db_m_fname = mysqli_real_escape_string($conn, $row['m_fname']);
            $db_m_lname = mysqli_real_escape_string($conn, $row['m_lname']);
            $db_m_mname = mysqli_real_escape_string($conn, $row['m_mname']);
            $db_hei_uii = mysqli_real_escape_string($conn, $row['hei_uii']);
            $db_birth_place = mysqli_real_escape_string($conn, $row['birth_place']);
            $db_nationality = mysqli_real_escape_string($conn, $row['nationality']);
            $db_present_street = mysqli_real_escape_string($conn, $row['present_street']);
            $db_present_barangay = mysqli_real_escape_string($conn, $row['present_barangay']);
            $db_present_city = mysqli_real_escape_string($conn, $row['present_city']); 
            $db_present_province = mysqli_real_escape_string($conn, $row['present_province']);   
            $db_present_zip = mysqli_real_escape_string($conn, $row['present_zip']);
            $db_permanent_street = mysqli_real_escape_string($conn, $row['permanent_street']);
            $db_permanent_barangay = mysqli_real_escape_string($conn, $row['permanent_barangay']);
            $db_permanent_city = mysqli_real_escape_string($conn, $row['permanent_city']);
            $db_permanent_province = mysqli_real_escape_string($conn, $row['permanent_province']);
            $db_permanent_zip = mysqli_real_escape_string($conn, $row['permanent_zip']);
            $db_contact = mysqli_real_escape_string($conn, $row['contact']);
            $db_email = mysqli_real_escape_string($conn, $row['email']);
            $db_lbp_branch = mysqli_real_escape_string($conn, $row['lbp_branch']);
            $db_id_number = mysqli_real_escape_string($conn, $row['id_number']);
            $db_id_type = mysqli_real_escape_string($conn, $row['id_type']);
            $db_emboss_name = mysqli_real_escape_string($conn, $row['emboss_name']);
            $db_profession = mysqli_real_escape_string($conn, $row['profession']);
            $db_source_of_fund_id = mysqli_real_escape_string($conn, $row['source_of_fund_id']);
            $db_gross_salary_id = mysqli_real_escape_string($conn, $row['gross_salary_id']);
            $db_tin = mysqli_real_escape_string($conn, $row['tin']);
            $db_photo = mysqli_real_escape_string($conn, $row['photo']);
            
            $db_mothermaiden = $db_m_fname." ".$db_m_mname." ".$db_m_lname;   
        }
    }
    
    
    
    //stop processing of exporting pdf if not all necessary field are filled out
    if(empty($db_title) || empty($db_marital_status) || empty($db_birth_place) || empty($db_present_street) || empty($db_present_barangay) || empty($db_present_city) || empty($db_present_province) || empty($db_present_zip) || empty($db_permanent_barangay) ||
    empty($db_lbp_branch) || empty($db_id_number) || empty($db_id_type) || empty($db_emboss_name) ||
    empty($db_profession) || empty($db_source_of_fund_id) || empty($db_gross_salary_id) || empty($db_tin) || empty($db_contact) || empty($db_email)){
       $msg = "Please fill out all fields with asterisk(*) and click save before exporting to PDF";
       header('location: ../forms.php?errmsg='.$msg);
       exit();
    }
    $sqlSelectBranch = "SELECT * FROM tbl_lbp_branches WHERE uid = ".$_POST['dd_branches']; 
    $resultsqlSelectBranch = mysqli_query($conn, $sqlSelectBranch); 
    $checksqlSelectBranch = mysqli_num_rows($resultsqlSelectBranch);
    if($checksqlSelectBranch > 0){
        while($row = mysqli_fetch_assoc($resultsqlSelectBranch)){
            $branchName = $row['branch_name'];
        }
    }
    
    $branches = str_replace("Ã±","n", $branchName);
    $fname = str_replace("Ã±","n", $db_fname);
    $mname = str_replace("Ã±","n", $db_mname);
    $lname = str_replace("Ã±","n", $db_lname);
    $title_char = str_replace("Ã±","n", $db_title);
    $marital_status_char = str_replace("Ã±","n", $db_marital_status);
    $gender = str_replace("Ã±","n", $_POST['txt_gender']);
    $dobirth = str_replace("Ã±","n", $_POST['txt_dateofbirth']);
    $text_dobirth = date("M d, Y", strtotime($dobirth));
    $pobirth = str_replace("Ã±","n", $_POST['txt_placeofbirth']);
    $nationality = str_replace("Ã±","n", $_POST['txt_nationality']);
    $mothermaiden = str_replace("Ã±","n", $db_mothermaiden);
    $hei = str_replace("Ã±","n", $_POST['txt_hei']);
    $mobile = str_replace("Ã±","n", $_POST['txt_mobile']);
    $email = str_replace("Ã±","n", $db_email);
    $perstreet = str_replace("Ã±","n", $_POST['txt_perstreet']);
    $perbrgy = str_replace("Ã±","n", $db_permanent_barangay);
    $percity = str_replace("Ã±","n", $_POST['txt_percity']);
    $perprovince = str_replace("Ã±","n", $_POST['txt_perprovince']);
    $perzip = str_replace("Ã±","n", $_POST['txt_perzip']);
    $prestreet = str_replace("Ã±","n", $_POST['txt_prestreet']);
    $prebrgy = str_replace("Ã±","n", $db_present_barangay);
    $precity = str_replace("Ã±","n", $_POST['txt_precity']);
    $preprovince = str_replace("Ã±","n", $_POST['txt_preprovince']);
    $prezip = str_replace("Ã±","n", $_POST['txt_prezip']);
    $day = date('Y/m/d');
    $text_day = date("M d, Y", strtotime($day));
    $typeofid_id = str_replace("Ã±","n", $_POST['dd_idtype']); 
    $idnumber = str_replace("Ã±","n", $_POST['txt_idnumber']);
    $prof = str_replace("Ã±","n", $_POST['txt_profession']);
    $sourceoffund_id = str_replace("Ã±","n", $_POST['dd_sourceoffund']);
    $tinnumber = str_replace("Ã±","n", $_POST['txt_tin']);
    $grosssalary_id = str_replace("Ã±","n", $_POST['dd_salary']);
    
    if($title_char == 'Mr'){
        $titlevalue = 78;
    }
    elseif($title_char == 'Ms'){
        $titlevalue = 75;
    }
    elseif($title_char == 'Mrs'){
        $titlevalue = 81;
    }
    //SQL FOR TYPE OF ID
    $sqlIDName = "SELECT * FROM tbl_lbp_id_type WHERE id_type = '".$typeofid_id."'";
    $resultsqlIDName = mysqli_query($conn, $sqlIDName);
    $checksqlIDName = mysqli_num_rows($resultsqlIDName);
    while($row=mysqli_fetch_assoc($resultsqlIDName)){
        $typeofid = mysqli_real_escape_string($conn, $row['id_type_name']);
    }

    //SQL FOR SOURCE NAME
    $sqlSourceName = "SELECT * FROM tbl_lbp_source_fund WHERE source_id = '".$sourceoffund_id."'";
    $resultsqlSourceName = mysqli_query($conn, $sqlSourceName);
    $checksqlSourceName = mysqli_num_rows($resultsqlSourceName);
    while($row=mysqli_fetch_assoc($resultsqlSourceName)){
        $sourceoffund = mysqli_real_escape_string($conn, $row['source']);
    }

    //SQL FOR GROSS SALARY
    $sqlgrosssalary = "SELECT * FROM tbl_lbp_gross_salary WHERE gsalary_id = '".$grosssalary_id."'";
    $resultsqlgrosssalary = mysqli_query($conn, $sqlgrosssalary);
    $checksqlgrosssalary = mysqli_num_rows($resultsqlgrosssalary);
    while($row=mysqli_fetch_assoc($resultsqlgrosssalary)){
        $grosssalary = mysqli_real_escape_string($conn, $row['salary_range']);

    }

    $supscript1 = '<sup>1</sup>';
    
    QRcode::png($special_code,"qr.png");
    $pdf = new FPDF('p','mm', array(215.9,330.2));
    $pdf->AddPage();
    $pdf->SetMargins(5,0,0);
    $pdf->SetAutoPageBreak(false,0);
    $pdf->Image("qr.png", 193, 14, 12, 12, "png");

    $pdf->SetFont('Arial', '', 10);
    $pdf->Image('../image/LandbankLogo.png',6,8,8,8);
    $pdf->Cell(5 ,-6 ,'',0,0);
    $pdf->Cell(160 ,0 ,'LAND BANK OF THE PHILIPPINES',0,0);
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(33 ,4 ,'Exhibit 2',0,1,'R');
    
    $studentFullName = $fname." ".$mname." ".$lname;

    $str = strtoupper($db_emboss_name);
    $i = strlen($db_emboss_name);
    $arr1 = str_split($db_emboss_name);
    
    $leftPosition = 22.4;
    foreach($arr1 as $i => $r){
        if($arr1[$i] == utf8_decode("ñ") || $arr1[$i] == utf8_decode("Ñ")){
            $pdf->Image('../image/letters/Enye.png',$leftPosition,201.4,5,5);
        }
        elseif($arr1[$i] == " "){
            $pdf->Image('../image/letters/space.png',$leftPosition,201.4,5,5);
        }
        else{
            $pdf->Image('../image/letters/'.$arr1[$i].'.png',$leftPosition,201.4,5,5);     
        }
        $leftPosition=$leftPosition+7.65;        
    }

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(10 ,1 ,'',0,0);
    $pdf->Cell(168 ,1 ,'Branch   '.$branches,0,1);
    $pdf->Image('../image/Line.png',25,-9.1,50,50);
    $pdf->Cell(185 ,1 ,'',0,1, 'C');

    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(205 ,2 ,'',0,1,'C');
    $pdf->Cell(205 ,8 ,'LANDBANK CASH CARD/PREPAID CARD ENROLLMENT FORM',0,1,'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(155 ,4 ,' ',0,0);
    $pdf->Cell(55 ,7 ,'Date:        '.$text_day,0,1,'C');
    $pdf->Image('../image/Line.png',178,6.3,34,50);

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(205 ,4 ,'Please check the type of card being enrolled: ',1,1,'L');
    
    $pdf->SetFont('Arial', '', 8);
    $pdf->Image('../image/CashCard.png',15,28,37,37);
    $pdf->Image('../image/check.png',82.8,37,3.5,3.5);
    $pdf->Image('../image/check.png',89,42,3.5,3.5);
    $pdf->Cell(55 ,15 ,'' ,1,0,'L');
    $pdf->Image('../image/PrepaidCard.png',80,29.6,89,36);
    $pdf->Image('../image/Select.png',110,36,86,9);
    $pdf->Cell(150 ,15 ,'',1,1,'L');

    $pdf->SetFont('Arial','B', 8);
    $pdf->Cell(205,4,"Purchaser's Information",1,1, 'C');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(125,4.27,"Purchaser's Name: " ,'L',0, 'L');
    $pdf->Cell(80,4.27,"With existing account with LBP " ,'LR',1, 'L');

    $pdf->Image('../image/YesNo.png',178 ,53.5,20,8);
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(125,4.27,$studentFullName ,'L',0, 'C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(80,4.27,"if yes, pls specify Acct. No/s:" ,'LR',1, 'L');

    $pdf->Image('../image/Line.png',172 ,38.5,34,50);
    $pdf->Image('../image/check.png',193.5,54.5,3.5,3.5);
    $pdf->Cell(125,3.5,'' ,'L',0, 'C');
    $pdf->Cell(80,3.5,"Cash Card Number/s:" ,'LBR',1, 'L');

    $pdf->Image('../image/Line.png',172 ,42.5,34,50);

    $pdf->SetFont('Arial','B', 8);
    $pdf->Cell(205,4,"ADDITIONAL INFORMATION FOR WALK-IN INDIVIDUAL PURCHASER, AND CARDHOLDER OF INSTITUTIONAL PURCHASER:" ,1,1, 'L');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(153.5,4,"Cardholder's Name:" ,'LR',0, 'L');
    $pdf->Cell(51.5,4,"Gender:" ,'LR',1, 'L');

    $pdf->Image('../image/title.png',6,75,15,20);
    $pdf->Image('../image/check.png',6.3,$titlevalue,4,4);

    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(153.5,4,$studentFullName,'LR',0, 'C');
    $pdf->Cell(51.5,4,$gender ,'LR',1, 'C');

    $pdf->Cell(153.5,0.5,"" ,'LR',0, 'L');
    $pdf->Cell(51.5,0.5,"" ,'LBR',1, 'L');

    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(153.5,3,"" ,'LR',0, 'L');
    $pdf->Cell(51.5,3,"Marital Status:" ,'LR',1, 'L');

    $pdf->Cell(153.5,3,"" ,'LR',0, 'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(51.5,3,"$marital_status_char" ,'LR',1, 'C');

    $pdf->Cell(153.5,3,"" ,'LBR',0, 'L');
    $pdf->Cell(51.5,3,"" ,'LBR',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(125.3,4.27,"Permanent Address:" ,'LR',0, 'L');
    $pdf->Cell(28.2,4.27,"Zip Code:" ,'LR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(125.3,4.27,$perstreet.', '.$perbrgy.',','LR',0, 'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(28.2,4.27,$perzip ,'LR',0, 'C');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(125.3,4.27,$percity.', '.$perprovince  ,'LBR',0, 'C');
    $pdf->Cell(28.2,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');

    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(125.3,4.27,"Present Address:" ,'LR',0, 'L');
    $pdf->Cell(28.2,4.27,"Zip Code:" ,'LR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(125.3,4.27,$prestreet.', '.$prebrgy.',','LR',0, 'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(28.2,4.27,$prezip ,'LR',0, 'C');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(125.3,4.27,$precity.', '.$preprovince  ,'LBR',0, 'C');
    $pdf->Cell(28.2,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(43,4.27,"Place of Birth:" ,'LR',0, 'L');
    $pdf->Cell(46,4.27,"Date of Birth:" ,'LR',0, 'L');
    $pdf->Cell(22.75,4.27,"Nationality:" ,'LR',0, 'L');
    $pdf->Cell(41.75,4.27,"Mother's Maiden Name:" ,'LR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');

    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(43,4.27,$pobirth ,'LR',0, 'C');
    $pdf->Cell(46,4.27,$text_dobirth ,'LR',0, 'C');
    $pdf->Cell(22.75,4.27,$nationality ,'LR',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(41.75,4.27,$mothermaiden ,'LR',0, 'C');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'C');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(43,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(46,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(22.75,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(41.75,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LBR',1, 'L');

    $pdf->Image('../image/box.png',162,94,44,44);
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(30,4.27,"Type of ID Presented:" ,'LR',0, 'L');
    $pdf->Cell(35,4.27,"ID Number Presented:" ,'LR',0, 'L');
    $pdf->Cell(24,4.27,"Profession:" ,'LR',0, 'L');
    $pdf->Cell(22.7,4.27,"TIN:" ,'LR',0, 'L');
    $pdf->Cell(41.7,4.27,"Source of Fund:" ,'LR',0, 'L');
    $pdf->Cell(51.6,4.27,"",'LR',1);

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(30,4.27,"$typeofid" ,'LR',0, 'C');
    $pdf->Cell(35,4.27,"$idnumber" ,'LR',0, 'C');
    $pdf->Cell(24,4.27,"$prof" ,'LR',0, 'C');
    $pdf->Cell(22.7,4.27,"$tinnumber" ,'LR',0, 'C');
    $pdf->Cell(41.7,4.27,"$sourceoffund" ,'LR',0, 'C');
    $pdf->Cell(51.6,4.27,"",'LR',1);

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(30,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(35,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(24,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(22.7,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(41.7,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(51.6,4.27,"",'LBR',1);

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(88.7,4.27,"Name of Employer/Company/Business/School:" ,'LR',0, 'L');
    $pdf->Cell(28.7,4.27,"Contact Number/s:" ,'LR',0, 'L');
    $pdf->Cell(35.9,4.27,"Email Address:" ,'LR',0, 'L');
    $pdf->Cell(51.6,4.27,"Gross Salary:" ,'LR',1, 'L');

    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(88.7,4.27,$hei ,'LR',0, 'C');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(28.7,4.27,$mobile ,'LR',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(35.9,4.27,$email ,'LR',0, 'C');
    $pdf->Cell(51.6,4.27,"$grosssalary" ,'LR',1, 'C');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(88.7,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(28.7,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(35.9,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(51.6,4.27,"" ,'LBR',1, 'L');
    
    $pdf->SetFont('Arial','B', 10);
    $pdf->Cell(205,4,"Cardholder's Information" ,1,1, 'C');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(95,4.27,"Cardholder's Name:" ,'LR',0, 'L');
    $pdf->Cell(50,4.27,"Contact Number/s:" ,'R',0, 'L');
    $pdf->Cell(60,4.27,"Date of Birth:" ,'LR',1, 'L');

    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(95,4.27,"$studentFullName",'LR',0, 'C');
    $pdf->Cell(50,4.27,"$mobile" ,'R',0, 'C');
    $pdf->Cell(60,4.27,"$text_dobirth" ,'R',1, 'C');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(95,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(50,4.27,"" ,'BR',0, 'L');
    $pdf->Cell(60,4.27,"" ,'BR',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(145,4.27,"Permanent Address:" ,'LR',0, 'L');
    $pdf->Cell(27,4.27,"Zip Code:" ,'R',0, 'L');
    $pdf->Cell(33,4.27,"Relationship with:" ,'LR',1, 'L');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,"$perstreet, $perbrgy",'LR',0, 'C');
    $pdf->Cell(27,4.27,"$perzip" ,'R',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(33,4.27,"the Purchaser" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,"$percity, $perprovince" ,'LBR',0, 'C');
    $pdf->Cell(27,4.27,"" ,'BR',0, 'C');
    $pdf->Cell(33,4.27,"" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(145,4.27,"Present Address:" ,'LR',0, 'L');
    $pdf->Cell(27,4.27,"Zip Code:" ,'R',0, 'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(33,4.27,"N/A" ,'LR',1, 'C');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,"$prestreet, $prebrgy",'LR',0, 'C');
    $pdf->Cell(27,4.27,"$prezip" ,'R',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(33,4.27,"" ,'R',1, 'C');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,"$precity, $preprovince" ,'LBR',0, 'C');
    $pdf->Cell(27,4.27,"" ,'BR',0, 'L');
    $pdf->Cell(33,4.27,"" ,'BR',1, 'L');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(205,4.27,"Name to Appear on the Card (maximum of 22 characters):" ,'LR',1, 'L');
    $pdf->Image('../image/boxes.png',6,199.5,195,9);
    $pdf->Cell(205,4.27,"" ,'LR',1, 'L');
    $pdf->Cell(205,4.27,"" ,'LBR',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(102.5,3,"Initial Load" ,'LR',0, 'L');
    $pdf->Cell(53.25,3,"Amount of Fee/Charges to be paid:" ,0,0, 'L');
    $pdf->Cell(49.25,3,"" ,'R',1, 'L');

    
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(102.5,1,"",'LR',0, 'C');
    $pdf->Cell(53.25,1,"" ,0,0, 'C');
    $pdf->Cell(49.25,1,"" ,'R',1, 'C');
    
    $pdf->Cell(102.5,3,"",'LR',0, 'C');
    $pdf->Cell(53.25,3,"" ,0,0, 'C');
    $pdf->Cell(49.25,3,"" ,'R',1, 'C');
    $pdf->Image('../image/pesos_sign.png',56,212,9,9);
    $pdf->Image('../image/dollar_sign.png',6,212,9,9);
    $pdf->Image('../image/Line.png',60,193.5,45,50);
    $pdf->Image('../image/Line.png',11,193.5,45,50);

    $pdf->Cell(102.5,3,"",'LR',0, 'C');
    $pdf->Cell(53.25,3,"" ,0,0, 'L');
    $pdf->Cell(49.25,3,"" ,'R',1, 'L');
    $pdf->Image('../image/pesos_sign.png',130,212,9,9);
    $pdf->Image('../image/Line.png',134,193.5,50,50);
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(102.5,3,"             (for Prepaid Travel Card)                  (for Cash Card/Regular Prepaid)" ,'L',0, 'L');
    $pdf->Cell(53.25,3,"                                                        (Initial Cost of the Card)",'L',0, 'C');
    $pdf->Cell(49.25,3,"" ,'R',1, 'L');        

    $pdf->Cell(102.5,3,"" ,'LBR',0, 'L');
    $pdf->Cell(53.25,3,"" ,'B',0, 'C');
    $pdf->Cell(49.25,3,"" ,'BR',1, 'L');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(102.5,3,"I/We hereby certify that the above information is true and correct:" ,'L',0, 'L');
    $pdf->Cell(102.5,3,"" ,'R',1, 'L');
    
    $pdf->Cell(102.5,3,"",'L',0, 'C');
    $pdf->Cell(102.5,3,"" ,'R',1, 'C');
    
    $pdf->Cell(102.5,3,"",'L',0, 'C');
    $pdf->Cell(102.5,3,"" ,'R',1, 'C');

    $pdf->Cell(102.5,3,"",'L',0, 'C');
    $pdf->Cell(102.5,3,"" ,'R',1, 'C');

    $pdf->Image('../image/Line.png',28,211.5,60,50);
    $pdf->Image('../image/Line.png',129,211.5,60,50);

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(102.5,3,"Signature Over Printed Name",'L',0, 'C');
    $pdf->Cell(102.5,3,"Signature Over Printed Name" ,'R',1, 'C');   
    
    $pdf->Cell(102.5,3,"of Purchaser/Applicant/Authorized Signatory",'L',0, 'C');
    $pdf->Cell(102.5,3,"of Purchaser/Applicant/Authorized Signatory" ,'R',1, 'C');

    $pdf->Cell(102.5,1,"" ,'LB',0, 'C');
    $pdf->Cell(102.5,1,"" ,'BR',1, 'L');

    $pdf->SetFont('Arial','B', 10);
    $pdf->Cell(205, 5, "FOR BANK'S USE ONLY", 1,1,"C");

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(68.33,3,"Processed by:" ,'LR',0, 'L');
    $pdf->Cell(68.33,3,"Checked by:" ,'R',0, 'L');
    $pdf->Cell(68.33,3,"Approved by:" ,'R',1, 'L');
    
    $pdf->Cell(68.33,3,"" ,'LR',0, 'C');
    $pdf->Cell(68.33,3,"" ,'R',0, 'C');
    $pdf->Cell(68.33,3,"" ,'R',1, 'C');
    
    $pdf->Cell(68.33,3,"" ,'LR',0, 'C');
    $pdf->Cell(68.33,3,"" ,'R',0, 'C');
    $pdf->Cell(68.33,3,"" ,'R',1, 'C');

    $pdf->Image('../image/Line.png',5,232.8,70,50);
    $pdf->Image('../image/Line.png',73,232.8,70,50);
    $pdf->Image('../image/Line.png',141.5,232.8,70,50);

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(68.33,3,"Customer Associate/NAC" ,'LR',0, 'C');
    $pdf->Cell(68.33,3,"BOO/BSO",'R',0, 'C');
    $pdf->Cell(68.33,3,"Branch Head" ,'R',1, 'C');  
    $pdf->Image('../image/forsupscript1.png',113,257,3.5,3.5);
    
    $pdf->Cell(68.33,1,"" ,'LR',0, 'C');
    $pdf->Cell(68.33,1,"" ,'R',0, 'C');
    $pdf->Cell(68.33,1,"" ,'R',1, 'C');
    
    $pdf->Cell(68.33,3,"Date/Time: ___________________" ,'LR',0, 'C');
    $pdf->Cell(68.33,3,"Date: ___________________" ,'R',0, 'C');
    $pdf->Cell(68.33,3,"Date: ___________________" ,'R',1, 'C');

    $pdf->Cell(68.33,1,"" ,'LBR',0, 'C');
    $pdf->Cell(68.33,1,"" ,'BR',0, 'C');
    $pdf->Cell(68.33,1,"" ,'BR',1, 'C');

    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(205,4,"   for Branches without BOO" ,0,1, 'L');
    $pdf->Image('../image/cut.png',-2, 255, 218, 30);
    $pdf->Cell(205,4,"Validation Print (if paid through cash):" ,0,1, 'L');
    $pdf->Image('../image/forsupscript1.png',5,265.5,3.5,3.5);
    
    $pdf->SetFont('Arial','B', 10);
    $pdf->Cell(205,4,"" ,0,1, 'C');
    $pdf->Cell(205, 5, "CASH CARD/PREPAID CARD/PIN MAILER CLAIM STUB", 1,1,"C");

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(51.25,3,"Card Number:" ,'LR',0, 'L');
    $pdf->Cell(51.25,3,"Card Holder's Name:" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"Purchaser's Name:" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"Date:" ,'R',1, 'L');


    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(51.25,3,"" ,'LR',0, 'L');
    $pdf->Cell(51.25,3,"" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(51.25,3,"" ,'LBR',0, 'L');
    $pdf->Cell(51.25,3,"" ,'BR',0, 'L');
    $pdf->Cell(51.25,3,"" ,'BR',0, 'L');
    $pdf->Cell(51.25,3,"" ,'BR',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(51.25,3,"Prepaid Card Released by:" ,'LR',0, 'L');
    $pdf->Cell(51.25,3,"PIN Haller Released by:" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"Approved for Release:" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"Card/PIN Mailer Recieved by:" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(51.25,3,"" ,'LR',0, 'L');
    $pdf->Cell(51.25,3,"" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"" ,'R',0, 'L');
    $pdf->Cell(51.25,3,"" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(51.25,5,"" ,'LR',0, 'L');
    $pdf->Cell(51.25,5,"" ,'R',0, 'L');
    $pdf->Cell(51.25,5,"" ,'R',0, 'L');
    $pdf->Cell(51.25,5,"" ,'R',1, 'L');

    $pdf->Image('../image/Line.png',5,278.2,52,50);
    $pdf->Image('../image/Line.png',56,278.2,52,50);
    $pdf->Image('../image/Line.png',107,278.2,52,50);
    $pdf->Image('../image/Line.png',159,278.2,52,50);

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(51.25,4,"Card Custodian" ,'LR',0, 'C');
    $pdf->Cell(51.25,4,"PIN Mailer Custodian" ,'R',0, 'C');
    $pdf->Cell(51.25,4,"Branch Head/BOO/BSO" ,'R',0, 'C');
    $pdf->Cell(51.25,4,"Signature Over Printed Name" ,'R',1, 'C');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(51.25,2,"" ,'LR',0, 'L');
    $pdf->Cell(51.25,2,"" ,'R',0, 'L');
    $pdf->Cell(51.25,2,"" ,'R',0, 'L');
    $pdf->Cell(51.25,2,"of Purchaser/Cardholder" ,'R',1, 'C');

    $pdf->Cell(51.25,2,"Date/Time: ___________________" ,'LR',0, 'L');
    $pdf->Cell(51.25,2,"Date/Time: ___________________" ,'R',0, 'L');
    $pdf->Cell(51.25,2,"" ,'R',0, 'L');
    $pdf->Cell(51.25,2,"" ,'R',1, 'C');

    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(51.25,1,"" ,'LBR',0, 'L');
    $pdf->Cell(51.25,1,"" ,'BR',0, 'L');
    $pdf->Cell(51.25,1,"" ,'BR',0, 'L');
    $pdf->Cell(51.25,1,"" ,'BR',1, 'L');

    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(205,3,"Reminder/s:" ,'LR',1, 'L');
    $pdf->Cell(205,3,"- You may claim your Prepaid Card after 7 banking days for Metro Manila Branches, and 15 banking days for Provincial Branches, and a replacement fee shall be collected" ,'LR',1, 'L');
    $pdf->Cell(205,3,"- Unclaimed Prepaid Card/PIN Mailer shall be perforated after 120 calendar days (for CCT)/30 calendar days (regular) from issuance/re-issuance" ,'LR',1, 'L');
    $pdf->Cell(205,3,"- Please sign your Prepaid Card immediately" ,'LBR',1, 'L');

    $pdf->Cell(102.5,3,"Validation Print (if debted from deposit account):" ,0,0, 'L');
    //$pdf->Cell(102.5,3,"Revised 03092018" ,0,1, 'R');


    if(!$db_photo){
        $db_photo = '../image/studentupload/default-transparent.png';
    }

    $pdf->Image($db_photo,158.8,89.55,50.8,50.8); //Student Photo

    $date = str_replace('/', '-', $day);
    $sqlDateExported = "UPDATE tbl_lbp_form SET date_exported = '$date' WHERE award_no = '$GLOBALawardeenumber'";
    
    mysqli_query($conn, $sqlDateExported);

    $pdf->output('D', $studentFullName.' - LandBank Form ('.$day.').pdf');


    //UPDATE editable_fields column
    /*$sqlUpdateEF = "UPDATE tbl_lbp_form SET editable_fields = 'NO' WHERE award_no = '$GLOBALawardeenumber'";
    mysqli_query($conn, $sqlUpdateEF);*/

}

//Change Student Password
if(isset($_POST['btn_change_password'])){
    
    $sqlCurrentPassword = "SELECT password FROM vw_complete_teslbp_data WHERE award_no = '$GLOBALawardeenumber'";
    $resCurrentPassword = mysqli_query($conn, $sqlCurrentPassword);
    $checkCurrentPassword = mysqli_num_rows($resCurrentPassword);

    if($checkCurrentPassword > 0){
        while($row = mysqli_fetch_assoc($resCurrentPassword)){
            $realCurrentPassword = mysqli_real_escape_string($conn, $row['password']);
        }        
    }
    else{
        $realCurrentPassword = 'not found';
    }

    $currentpassword = $_POST['txt_current_password'];
    $newpassword = $_POST['txt_new_password'];
    $retypepassword = $_POST['txt_retype_password'];

    // echo 'current password is: '.$currentpassword.'<br>new password is: '.$newpassword.'<br> retyped password is: '.$retypepassword.'<br>real current password is: '.$realCurrentPassword;

    if($realCurrentPassword == $currentpassword){
        if($currentpassword != $newpassword){
            if($newpassword == $retypepassword){
                $sqlUpdatePassword = "UPDATE tbl_lbp_form SET password = '$newpassword' WHERE award_no = '$GLOBALawardeenumber'";
                mysqli_query($conn, $sqlUpdatePassword);

                $msg = "Your password is successfuly updated";
                header('location: ../account_settings.php?sucmsg='.$msg);
                exit();
            }
            else{
                $msg = "Please confirm your new password by re-typing it";
                header('location: ../account_settings.php?errmsg='.$msg);
                exit();
            }
        }
        else{
            $msg = "Your new and old password cannot be the same";
            header('location: ../account_settings.php?errmsg='.$msg);
            exit();
        }
    }
    else{
        $msg = "Please type your current password correctly";
        header('location: ../account_settings.php?errmsg='.$msg);
        exit();
    }

}

//Send Email to UniFAST
/*
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
    

    if(isset($_POST['btn_send'])){
        $to = $_POST['jbahil47@gmail.com'];
        $subject = $_POST['txt_subject'];
        $message = $_POST['txt_message'];
        $from = "jbahil47@gmail.com";
        
        mail($to, $subject, $message);
    }*/
?>