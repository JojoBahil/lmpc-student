<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    
//     header("Content-Type:text/html; charset=utf-8");
//     $connect -> set_charset('utf8');
    include('dbconn.php');
    include('../plugin_fpdf_merge/fpdf_merge.php');    
    header("Content-Type:text/html; charset=ISO-8859-1");
    require('../fpdf181/fpdf.php');
    require("../phpqrcode/qrlib.php");
    session_start();

    $GLOBALawardeenumber = $_SESSION['awardeenumber'];
    $GLOBALawardeenumber = trim($GLOBALawardeenumber);

    $ACADEMIC_YEAR = "2021-2022";
    $g_ac_year = "2021_2022";
    $GLOBAL_ac_year = $_SESSION['g_ac_year'];
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
        /* ACCESS FOR SPECIFIC REGION */
        $sql = "SELECT * FROM tbl_lbp_form a INNER JOIN tbl_heis b ON a.hei_uii = b.hei_uii WHERE a.award_no ='$awardeenum' AND a.password = MD5('$password') 
        -- AND (a.status = 'Not Finalized' OR a.status = 'Finalized' OR a.status = 'Rejected' OR a.status = 'REQTOUNFINALIZE') 
        AND (a.tag = 'NEW' OR a.tag = 'ON-GOING' OR a.tag = 'ON-GOING LISTAHANAN' OR a.tag = 'FOR TESTING')
        AND a.active_grantee = 'YES'
        AND a.hei_uii = 'ase123123qase'
        ";

        // (b.hei_region_nir = '05 - Bicol Region' OR b.hei_region_nir = '06 - Western Visayas' OR b.hei_region_nir = '13 - NCR' OR b.hei_region_nir = '01 - Ilocos Region' OR b.hei_region_nir = '08 - Eastern Visayas' OR b.hei_region_nir = '11 - Davao Region' OR b.hei_region_nir = '03 - Central Luzon' OR b.hei_region_nir = '15 - BARMM' OR b.hei_region_nir = '15A - BARMM' OR b.hei_region_nir = '15B - BARMM' OR b.hei_region_nir = '16 - Caraga' OR b.hei_region_nir = '12 - Soccsksargen' OR b.hei_region_nir = '10 - Northern Mindanao' OR b.hei_region_nir = '17 - MIMAROPA' OR b.hei_region_nir = '07 - Central Visayas' OR b.hei_region_nir = '09 - Zamboanga Peninsula' OR b.hei_region_nir = '05 - Bicol Region' OR b.hei_region_nir = '06 - Western Visayas' OR b.hei_region_nir = '13 - NCR' OR b.hei_region_nir = '01 - Ilocos Region' OR b.hei_region_nir = '08 - Eastern Visayas' OR b.hei_region_nir = '11 - Davao Region' OR b.hei_region_nir = '03 - Central Luzon' OR b.hei_region_nir = '15 - BARMM' OR b.hei_region_nir = '15A - BARMM' OR b.hei_region_nir = '15B - BARMM' OR b.hei_region_nir = '16 - Caraga' OR b.hei_region_nir = '12 - Soccsksargen' OR b.hei_region_nir = '10 - Northern Mindanao' OR b.hei_region_nir = '02 - Cagayan Valley' OR b.hei_region_nir = '04 - CALABARZON' OR b.hei_region_nir = '14 - CAR' OR )";
        /*------2nd BATCH-------*/ //(b.hei_region_nir = '01 - Ilocos Region' OR b.hei_region_nir = '08 - Eastern Visayas' OR b.hei_region_nir = '11 - Davao Region' OR b.hei_region_nir = '03 - Central Luzon' OR b.hei_region_nir = '15 - BARMM' OR b.hei_region_nir = '15A - BARMM' OR b.hei_region_nir = '15B - BARMM' OR b.hei_region_nir = '16 - Caraga')";
        /*------ALL REGIONS-------*/ //(b.hei_region_nir = '09 - Zamboanga Peninsula' OR b.hei_region_nir = '07 - Central Visayas' OR b.hei_region_nir = '04 - CALABARZON' OR b.hei_region_nir = '14 - CAR' OR b.hei_region_nir = '14 - Cordillera Administrative Region' OR b.hei_region_nir = '02 - Cagayan Valley' OR b.hei_region_nir = '17 - MIMAROPA' OR b.hei_region_nir = '06 - Western Visayas' OR b.hei_region_nir = '05 - Bicol Region' OR b.hei_region_nir = '13 - NCR' OR b.hei_region_nir = '11 - Davao Region' OR b.hei_region_nir = '08 - Eastern Visayas' OR b.hei_region_nir = '01 - Ilocos Region' OR b.hei_region_nir = '15 - BARMM' OR b.hei_region_nir = '15A - BARMM' OR b.hei_region_nir = '15B - BARMM' OR b.hei_region_nir = '03 - Central Luzon' OR b.hei_region_nir = '16 - Caraga' OR b.hei_region_nir = '10 - Northern Mindanao' OR b.hei_region_nir = '12 - Soccsksargen')";
        $results = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($results);

        if($resultCheck > 0){
            $_SESSION['awardeenumber'] = $awardeenum;
            $_SESSION['g_ac_year'] = $g_ac_year; 
            while($row = mysqli_fetch_assoc($results)){
                $privacy_agreement = mysqli_real_escape_string($conn, $row['privacy_agreement']);
            }
            
            //if($privacy_agreement == 'YES'){
            //    header("location: ../instructions.php");  
            //}
            //elseif($privacy_agreement == 'NO' || $privacy_agreement == '' || $privacy_agreement == NULL){
                header('location: ../privacyagreement.php');
            //}
                
        }
        else{
            $msglogin = "Failed to login? Possible reasons are: <br><br>1) You entered an incorrect credential<br>2) Your TES data is being validated at the moment<br>3) Your TES data did not pass the validation. <br><br> Please follow the UniFAST official page at <a href='https://www.facebook.com/unifastofficial' target='_blank'>www.facebook.com/unifastofficial</a> for more information and to see the latest news and announcements. <br><br>";
            header("location: ../index.php?notmatchedlogin=".$msglogin);
        }
    }

    
}


//Privacy Terms
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

//Change Student Password
if(isset($_POST['btn_change_password'])){
    
    /*
    $sqlCurrentPassword = "SELECT password FROM vw_complete_teslbp_data_2019_2020 WHERE award_no = '$GLOBALawardeenumber'";
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
    */
    
    $currentpassword = $_POST['txt_current_password'];
    $newpassword = $_POST['txt_new_password'];
    $retypepassword = $_POST['txt_retype_password'];

    // echo 'current password is: '.$currentpassword.'<br>new password is: '.$newpassword.'<br> retyped password is: '.$retypepassword.'<br>real current password is: '.$realCurrentPassword;
    $sql = "SELECT password FROM tbl_lbp_form WHERE award_no = '$GLOBALawardeenumber' 
            AND password= '".MD5($currentpassword)."'";
    $cPass_exists = mysqli_query($conn, $sql);
    $cPass_exists = mysqli_num_rows($cPass_exists);        
    if($cPass_exists > 0){
        if($currentpassword != $newpassword){
            if (preg_match('/[A-Za-z]/', $newpassword) && preg_match('/[0-9]/', $newpassword)){
                if($newpassword == $retypepassword){
                    $sqlUpdatePassword = "UPDATE tbl_lbp_form SET password = MD5('$newpassword') WHERE award_no = '$GLOBALawardeenumber'";
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
            }else{
                $msg = "Your password must contain letter/s and number/s";
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



//Save changes


if(isset($_POST['btn_save'])){ 
   
    //SAVE STUDENT INFO
    $sqlfind = "SELECT award_no, photo, hei_uii FROM tbl_lbp_form WHERE award_no = '$GLOBALawardeenumber'";
    $res = mysqli_query($conn, $sqlfind);
    $resCheck = mysqli_num_rows($res);
    while($row = mysqli_fetch_assoc($res)){
        $existingPhoto = mysqli_real_escape_string($conn, $row['photo']);
        $hei_uii = mysqli_real_escape_string($conn, $row['hei_uii']);
    }
    

    if($resCheck == 1){
        // UPDATE tbl_lbp_form for additional grantee info   
        
        if(isset($_POST['chk_sameAddress'])){
            $prestreet = mysqli_real_escape_string($conn, $_POST['txt_perstreet']);
            $prebrgy = mysqli_real_escape_string($conn, $_POST['txt_perbrgy']);
            $precity = mysqli_real_escape_string($conn, $_POST['txt_percity']);
            $preprovince = mysqli_real_escape_string($conn, $_POST['txt_perprovince']);
            $prezip =  mysqli_real_escape_string($conn, $_POST['txt_perzip']);
        }
        elseif(!isset($_POST['chk_sameAddress'])){
            $prestreet = mysqli_real_escape_string($conn, $_POST['txt_prestreet']);
            $prebrgy = mysqli_real_escape_string($conn, $_POST['txt_prebrgy']);
            $precity = mysqli_real_escape_string($conn, $_POST['txt_precity']);
            $preprovince = mysqli_real_escape_string($conn, $_POST['txt_preprovince']); 
            $prezip = mysqli_real_escape_string($conn, $_POST['txt_prezip']); 
        }
        
        /*
        if($_POST['dd_branches'] == "Select your most accessible branch"){
            $branchName = "";
        }
        else{
            $sqlSelectBranch = "SELECT * FROM tbl_lbp_branches WHERE uid = ".$_POST['dd_branches']; 
            $resultsqlSelectBranch = mysqli_query($conn, $sqlSelectBranch); 
            $checksqlSelectBranch = mysqli_num_rows($resultsqlSelectBranch);
            if($checksqlSelectBranch > 0){
                while($row = mysqli_fetch_assoc($resultsqlSelectBranch)){
                    $branchName = mysqli_real_escape_string($conn, $row['branch_name']);
                }
            }  
        }
        */
        $branchRegion = mysqli_real_escape_string($conn, $_POST['dd_location']);
        $fname = mysqli_real_escape_string($conn, $_POST['txt_fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['txt_mname']);
        $lname = mysqli_real_escape_string($conn, $_POST['txt_lname']);
        $title = mysqli_real_escape_string($conn, $_POST['dd_title']);
        $gender = mysqli_real_escape_string($conn, $_POST['txt_gender']);
        $marital_status = mysqli_real_escape_string($conn, $_POST['dd_marital_status']);
        $m_fname = mysqli_real_escape_string($conn, $_POST['txt_fmothername']);
        $m_mname = mysqli_real_escape_string($conn, $_POST['txt_mmothername']);
        $m_lname = mysqli_real_escape_string($conn, $_POST['txt_lmothername']);
        $dobirth = mysqli_real_escape_string($conn, $_POST['txt_dateofbirth']);
        $pobirth = mysqli_real_escape_string($conn, $_POST['txt_placeofbirth']);
        $nationality = mysqli_real_escape_string($conn, $_POST['txt_nationality']);
        $idnumber = mysqli_real_escape_string($conn, $_POST['txt_idnumber']);
        $idtype = "02";
        $tin = mysqli_real_escape_string($conn, $_POST['txt_tin']);
        $profession = mysqli_real_escape_string($conn, $_POST['txt_profession']);
        $sourcefund_id = mysqli_real_escape_string($conn, $_POST['dd_sourceoffund']);
        $gross_salary_id = "1";
        $sourcefund_id = "99";
        $perstreet = mysqli_real_escape_string($conn, $_POST['txt_perstreet']);
        $perbrgy = mysqli_real_escape_string($conn, $_POST['txt_perbrgy']);
        $percity = mysqli_real_escape_string($conn, $_POST['txt_percity']);
        $perprovince = mysqli_real_escape_string($conn, $_POST['txt_perprovince']);
        $perzip = mysqli_real_escape_string($conn, $_POST['txt_perzip']);
        $mobile = mysqli_real_escape_string($conn, $_POST['txt_mobile']);
        $email = mysqli_real_escape_string($conn, $_POST['txt_email']);
        $emboss = mysqli_real_escape_string($conn, $_POST['txt_emboss']);
        $expiry_date = mysqli_real_escape_string($conn, $_POST['txt_expirydate']);
        $pickup_at_hei = mysqli_real_escape_string($conn, $_POST['chk_pickup_at_hei']);
        
        $u_photo = $_FILES['file_photo'];
        
        $mobile = '+63'.$mobile;
        
        $emboss = strtoupper($emboss);
        
        if(strpos($emboss, '-') || strpos($emboss, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Emboss Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }
        
        if(strpos($fname, '-') || strpos($fname, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }

        if(strpos($mname, '-') || strpos($mname, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }

        if(strpos($lname, '-') || strpos($lname, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }

        if(strpos($m_fname, '-') || strpos($m_fname, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }

        if(strpos($m_mname, '-') || strpos($m_mname, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }

        if(strpos($m_lname, '-') || strpos($m_lname, '.')){
            $msg = "Dash (-) and Dot (.) is not allowed for Name";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }
        
        if(!isset($_POST['chk_pickup_at_hei'])){
            if($_POST['dd_branches'] == "Select your most accessible branch"){
                $branchName = "";
            }
            if($_POST['dd_location'] == "Select Region"){
                $branchRegion = "";
            }
            else{
                $sqlSelectBranch = "SELECT * FROM tbl_lbp_branches WHERE branch_code = ".$_POST['dd_branches'];
                $resultsqlSelectBranch = mysqli_query($conn, $sqlSelectBranch); 
                $checksqlSelectBranch = mysqli_num_rows($resultsqlSelectBranch);
                if($checksqlSelectBranch > 0){
                    while($row = mysqli_fetch_assoc($resultsqlSelectBranch)){
                        $branchCode = $_POST['dd_branches'];
                        $branchName = $row['branch_name'];
                        // $branchName = mysqli_real_escape_string($conn, $row['branch_name']);
                    }
                }  
            }
        }
        elseif(isset($_POST['chk_pickup_at_hei'])){
            $sqlServicingBranchCode = "SELECT * FROM tbl_lbp_servicing_branches WHERE hei_uii = '".$hei_uii."'";
            $resServicingBranchCode = mysqli_query($conn, $sqlServicingBranchCode);
            $checkServicingBranchCode = mysqli_num_rows($resServicingBranchCode);
            if($checkServicingBranchCode > 0){
                while($row = mysqli_fetch_assoc($resServicingBranchCode)){
                    $branchCode = $row['branch_code'];
                    $branchName = $row['branch'];
                    $branchRegion = $row['region'];
                }
            }

            // $branchName = "";
            // $branchRegion = "";
        }


        if(strpos($email, '.com') !== false || strpos($email, '.org') !== false || strpos($email, '.cc') !== false || strpos($email, '.co') !== false || strpos($email, '.com.ph') !== false || strpos($email, '.gov.ph') !== false || strpos($email, '.edu.ph') !== false){
            $email = $email;
        }
        elseif(strpos($email, '-')){
            $msg = "Please try using other email that has no special character like (-)Dash.";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }
        else{
            $msg = "Invalid Email";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }
        
        if(strpos($email, '-') == true){
            $msg = "Please use an Email Address that doesn't contain Dashes or other special characters.";
            header('location: ../forms.php?errmsg='.$msg);
            exit();
        }

        // ID
        $sqlfindfrontexisting = "SELECT award_no, id_front_photo, id_back_photo FROM tbl_lbp_form WHERE award_no = '$GLOBALawardeenumber'";
        $res = mysqli_query($conn, $sqlfindfrontexisting);
        $resCheck = mysqli_num_rows($res);
        while($row = mysqli_fetch_assoc($res)){
            $front_existingPhoto = $row['id_front_photo'];
            $back_existingPhoto = $row['id_back_photo'];
        }

        if(!empty($_FILES['file_idfront']['name'])){
            $u_front_photoName = $_FILES['file_idfront']['name'];
            $u_front_photoTmpName = $_FILES['file_idfront']['tmp_name'];
            $u_front_photoSize = $_FILES['file_idfront']['size'];
            $u_front_photoError = $_FILES['file_idfront']['error'];
            $u_front_photoType = $_FILES['file_idfront']['type'];
            
            $front_fileExt = explode('.', $u_front_photoName);
            $front_fileActualExt = strtolower(end($front_fileExt));

            $front_allowed = array('jpg', 'jpeg');

            if(!$front_existingPhoto){
                // echo "you have no exisiting photo";
                if($u_front_photoSize > 0){
                    if(in_array($front_fileActualExt, $front_allowed)){
                        if($u_front_photoError === 0){
                            if($u_front_photoSize < 2000000){
                                
        
                                $front_photoNewName = uniqid('', true).".".$front_fileActualExt;
                                $front_fileDestination = "../image/idfrontupload/".$GLOBALawardeenumber." - ".$front_photoNewName;
                                move_uploaded_file($u_front_photoTmpName, $front_fileDestination);

                                $sqluploadidfrontphoto = "UPDATE tbl_lbp_form set id_front_photo = '$front_fileDestination' WHERE award_no = '$GLOBALawardeenumber'";
                                mysqli_query($conn, $sqluploadidfrontphoto);
                            }
                            else{
                                $msg = "FILE UPLOAD ERROR: Your file is too big";
                                header('location: ../forms.php?errmsg='.$msg);
                                exit();
                            }
                        }
                        else{
                            $msg = "FILE UPLOAD ERROR: There was an error uploading your file";
                            header('location: ../forms.php?errmsg='.$msg);
                            exit();
                        }
                    }
                    else{
                        $msg = "FILE UPLOAD ERROR: Please select a valid file format for photo";
                        header('location: ../forms.php?errmsg='.$msg);
                        exit();
                    }
                }
                
                
            }
            elseif($front_existingPhoto){ 
                if($u_front_photoName){
                    unlink($front_existingPhoto);//delete existing photo 
                    
                    if(in_array($front_fileActualExt, $front_allowed)){
                        if($u_front_photoError === 0){
                            if($u_front_photoSize < 2000000){
                                $front_photoNewName = uniqid('', true).".".$front_fileActualExt;
                                $front_fileDestination = "../image/idfrontupload/".$GLOBALawardeenumber." - ".$front_photoNewName;
                                move_uploaded_file($u_front_photoTmpName, $front_fileDestination);

                                $sqluploadidfrontphoto = "UPDATE tbl_lbp_form set id_front_photo = '$front_fileDestination' WHERE award_no = '$GLOBALawardeenumber'";
                                mysqli_query($conn, $sqluploadidfrontphoto);
                            }
                            else{
                                $msg = "FILE UPLOAD ERROR: Your file is too big";
                                header('location: ../forms.php?errmsg='.$msg);
                                exit();
                            }
                        }
                        else{
                            $msg = "FILE UPLOAD ERROR: There was an error uploading your file";
                            header('location: ../forms.php?errmsg='.$msg);
                            exit();
                        }
                    }
                    else{
                        $msg = "FILE UPLOAD ERROR: Please select a valid file format for photo";
                        header('location: ../forms.php?errmsg='.$msg);
                        exit();
                    }
                }
                else{
                    $front_fileDestination = $front_existingPhoto;
                }
                
            }
        }
    
        //SAVE IMAGE to Folder "idbackupload" (ID BACK)

        if(!empty($_FILES['file_idback']['name'])){
            $u_back_photoName = $_FILES['file_idback']['name'];
            $u_back_photoTmpName = $_FILES['file_idback']['tmp_name'];
            $u_back_photoSize = $_FILES['file_idback']['size'];
            $u_back_photoError = $_FILES['file_idback']['error'];
            $u_back_photoType = $_FILES['file_idback']['type'];
            
            $back_fileExt = explode('.', $u_back_photoName);
            $back_fileActualExt = strtolower(end($back_fileExt));
    
            $back_allowed = array('jpg', 'jpeg');
    
            if(!$back_existingPhoto){
                // echo "you have no exisiting photo";
                if($u_back_photoSize > 0){
                    if(in_array($back_fileActualExt, $back_allowed)){
                        if($u_back_photoError === 0){
                            if($u_back_photoSize < 2000000){                
                                $back_photoNewName = uniqid('', true).".".$back_fileActualExt;
                                $back_fileDestination = "../image/idbackupload/".$GLOBALawardeenumber." - ".$back_photoNewName;
                                move_uploaded_file($u_back_photoTmpName, $back_fileDestination);
    
                                $sqluploadidbackphoto = "UPDATE tbl_lbp_form set id_back_photo = '$back_fileDestination' WHERE award_no = '$GLOBALawardeenumber'";
                                mysqli_query($conn, $sqluploadidbackphoto);
                            }
                            else{
                                $msg = "FILE UPLOAD ERROR: Your file is too big";
                                header('location: ../forms.php?errmsg='.$msg);
                                exit();
                            }
                        }
                        else{
                            $msg = "FILE UPLOAD ERROR: There was an error uploading your file";
                            header('location: ../forms.php?errmsg='.$msg);
                            exit();
                        }
                    }
                    else{
                        $msg = "FILE UPLOAD ERROR: Please select a valid file format for photo";
                        header('location: ../forms.php?errmsg='.$msg);
                        exit();
                    }
                }
                
            }
            elseif($back_existingPhoto){ 
                unlink($back_existingPhoto);//delete existing photo 
                if($u_back_photoSize > 0){
                    if(in_array($back_fileActualExt, $back_allowed)){
                        if($u_back_photoError === 0){
                            if($u_back_photoSize < 2000000){
                                $back_photoNewName = uniqid('', true).".".$back_fileActualExt;
                                $back_fileDestination = "../image/idbackupload/".$GLOBALawardeenumber." - ".$back_photoNewName;
                                move_uploaded_file($u_back_photoTmpName, $back_fileDestination);

                                $sqluploadidbackphoto = "UPDATE tbl_lbp_form set id_back_photo = '$back_fileDestination' WHERE award_no = '$GLOBALawardeenumber'";
                                mysqli_query($conn, $sqluploadidbackphoto);
                            }
                            else{
                                $msg = "FILE UPLOAD ERROR: Your file is too big";
                                header('location: ../forms.php?errmsg='.$msg);
                                exit();
                            }
                        }
                        else{
                            $msg = "FILE UPLOAD ERROR: There was an error uploading your file";
                            header('location: ../forms.php?errmsg='.$msg);
                            exit();
                        }
                    }
                    else{
                        $msg = "FILE UPLOAD ERROR: Please select a valid file format for photo";
                        header('location: ../forms.php?errmsg='.$msg);
                        exit();
                    }
                }
                else{
                    $back_fileDestination = $back_existingPhoto;
                }
                
            }
        }
        
        if(!empty($pickup_at_hei)){
            $pickup_at_hei = '1';
        }
        else{
            $pickup_at_hei = '0';
        }
         
        //AUTOMATE EMBOSS NAME
        $new_emboss_mname;
        $mname_emboss = $mname;
        if(strlen($mname_emboss) > 1){
            while(strlen($mname_emboss) > 1){
                $mname_emboss = substr($mname_emboss, 0, -1);
            }
            $new_emboss_mname = $mname_emboss;
            $emboss_name = $fname.' '.$new_emboss_mname.' '.$lname;
        }
        elseif($mname_emboss == '' || $mname_emboss == NULL){
            $emboss_name = $fname.' '.$lname;
        }

        if(strlen($emboss_name) > 22){
            $string_difference = strlen($emboss_name) - 22;
            $fname_new = substr($fname, 0, -$string_difference);
            $emboss_name = $fname_new.' '.$new_emboss_mname.' '.$lname; 
        }
        $emboss_name = strtoupper($emboss_name);
         
        $sql = "UPDATE tbl_lbp_form set 
        lbp_branch_region = '$branchRegion',
        lbp_branch_code = '$branchCode',
        lbp_branch = '$branchName',
        fname = '$fname',
        mname = '$mname',
        lname = '$lname',
        m_fname = '$m_fname',
        m_mname = '$m_mname',
        m_lname = '$m_lname',
        birthdate = '$dobirth',
        birth_place = '$pobirth',
        title = '$title',
        sex = '$gender',
        marital_status = '$marital_status',
        nationality = '$nationality',
        id_number = '$idnumber',
        id_type = '$idtype',
        id_expire_date = '2025-12-31',
        tin = '$tin',
        profession = '$profession',
        source_of_fund_id = '$sourcefund_id',
        gross_salary_id = '1',
        permanent_street = '$perstreet',
        permanent_barangay = '$perbrgy',
        permanent_city = '$percity',      
        permanent_province = '$perprovince',
        permanent_zip = '$perzip',
        present_street = '$prestreet',
        present_barangay = '$prebrgy',
        present_city = '$precity',       
        present_province = '$preprovince',
        present_zip = '$prezip',
        contact = '$mobile',
        email = '$email',
        emboss_name = '$emboss_name',
        pickup_at_hei = '$pickup_at_hei'
        WHERE award_no = '$GLOBALawardeenumber'";
        
    
        mysqli_query($conn, $sql);

        if(mysqli_query($conn, $sql)){
            $msg = "Update Successful";
            header("location: ../forms.php?sucmsg=".$msg);
        }
        else{
            $msg = "Update Failed";
            header("location: ../forms.php?errmsg=".$msg);
        }
    }
   
}

/*
QRcode::png($special_code,"qr.png");
    $pdf = new FPDF('p','mm', array(215.9,330.2));
    $pdf->AddPage();
    $pdf->SetMargins(5,0,0);
    $pdf->SetAutoPageBreak(false,0);
    $pdf->Image("qr.png", 193, 14, 12, 12, "png");
*/

if(isset($_POST['btn_export'])){ 
    $sqlQuery = "SELECT * FROM tbl_lbp_form WHERE award_no = '$GLOBALawardeenumber'";
    $result = mysqli_query($conn, $sqlQuery);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)){
        
        if ($resultCheck == 1){
            $db_app_id = mysqli_real_escape_string($conn, $row['app_id']);
            $db_award_no = mysqli_real_escape_string($conn, $row['award_no']);
//             $db_ac_year = mysqli_real_escape_string($conn, $row['ac_year']);
            $db_lname = utf8_decode(mysqli_real_escape_string($conn, $row['lname']));
            $db_fname = utf8_decode(mysqli_real_escape_string($conn, $row['fname']));
            $db_mname = utf8_decode(mysqli_real_escape_string($conn, $row['mname']));
            $db_sex = mysqli_real_escape_string($conn, $row['sex']);
            $db_title = mysqli_real_escape_string($conn, $row['title']);
            $db_marital_status = mysqli_real_escape_string($conn, $row['marital_status']);
            $db_birthdate = mysqli_real_escape_string($conn, $row['birthdate']);
            $db_m_fname = utf8_decode(mysqli_real_escape_string($conn, $row['m_fname']));
            $db_m_lname = utf8_decode(mysqli_real_escape_string($conn, $row['m_lname']));
            $db_m_mname = utf8_decode(mysqli_real_escape_string($conn, $row['m_mname']));
            $db_hei_uii = mysqli_real_escape_string($conn, $row['hei_uii']);
            $db_birth_place = utf8_decode(mysqli_real_escape_string($conn, $row['birth_place']));
            $db_nationality = mysqli_real_escape_string($conn, $row['nationality']);
            $db_present_street = utf8_decode(mysqli_real_escape_string($conn, $row['present_street']));
            $db_present_barangay = utf8_decode(mysqli_real_escape_string($conn, $row['present_barangay']));
            $db_present_city = utf8_decode(mysqli_real_escape_string($conn, $row['present_city'])); 
            //$db_present_citymm = utf8_decode(mysqli_real_escape_string($conn, $row['present_citymm'])); 
            $db_present_province = utf8_decode(mysqli_real_escape_string($conn, $row['present_province']));   
            $db_present_zip = utf8_decode(mysqli_real_escape_string($conn, $row['present_zip']));
            $db_permanent_street = utf8_decode(mysqli_real_escape_string($conn, $row['permanent_street']));
            $db_permanent_barangay = utf8_decode(mysqli_real_escape_string($conn, $row['permanent_barangay']));
            $db_permanent_city = utf8_decode(mysqli_real_escape_string($conn, $row['permanent_city']));
            //$db_permanent_citymm = utf8_decode(mysqli_real_escape_string($conn, $row['permanent_citymm']));
            $db_permanent_province = utf8_decode(mysqli_real_escape_string($conn, $row['permanent_province']));
            $db_permanent_zip = utf8_decode(mysqli_real_escape_string($conn, $row['permanent_zip']));
            $db_contact = mysqli_real_escape_string($conn, $row['contact']);
            $db_email = utf8_decode(mysqli_real_escape_string($conn, $row['email']));
            $db_lbp_branch_code = utf8_decode(mysqli_real_escape_string($conn, $row['lbp_branch_code']));
            $db_lbp_branch = utf8_decode(mysqli_real_escape_string($conn, $row['lbp_branch']));
            $db_id_number = utf8_decode(mysqli_real_escape_string($conn, $row['id_number']));
            $db_id_type = mysqli_real_escape_string($conn, $row['id_type']);
            $db_emboss_name = utf8_decode(mysqli_real_escape_string($conn, $row['emboss_name']));
            $db_profession = utf8_decode(mysqli_real_escape_string($conn, $row['profession']));
            $db_source_of_fund_id = mysqli_real_escape_string($conn, $row['source_of_fund_id']);
            $db_gross_salary_id = mysqli_real_escape_string($conn, $row['gross_salary_id']);
            $db_tin = mysqli_real_escape_string($conn, $row['tin']);
            $db_photo = mysqli_real_escape_string($conn, $row['photo']);
            $db_id_front_photo = mysqli_real_escape_string($conn, $row['id_front_photo']);
            $db_id_back_photo = mysqli_real_escape_string($conn, $row['id_back_photo']);
            $db_id_expire_date = mysqli_real_escape_string($conn, $row['id_expire_date']);
            $db_mothermaiden = $db_m_fname." ".$db_m_mname." ".$db_m_lname;   
            $id_front_size = getimagesize($db_id_front_photo);
            $id_back_size = getimagesize($db_id_back_photo);
            $db_pickup_at_hei = mysqli_real_escape_string($conn, $row['pickup_at_hei']);
            $db_status = mysqli_real_escape_string($conn, $row['status']);
            $db_pdf_attachment = mysqli_real_escape_string($conn, $row['pdf_attachment']);
            
            //DELETE PDF IF UNFINALIZED THROUGH HEI PORTAL
            if($db_pdf_attachment != NULL || $db_pdf_attachment == ''){
                if($db_status == "Not Finalized" || $db_status == "Rejected"){
                    $sqlPDFpath = "SELECT pdf_attachment FROM tbl_lbp_form WHERE award_no = '".$awardno."'";
                    $resPDFpath = mysqli_query($conn, $sqlPDFpath);
                    $checkPDFpath = mysqli_num_rows($resPDFpath);
                    if($checkPDFpath > 0){
                        while($row=mysqli_fetch_assoc($resPDFpath)){
                            $pdf_attachment = $row['pdf_attachment']; 
                        }

                        $updateUnfinalizeAccount = "UPDATE tbl_lbp_form SET editable_fields = NULL, pdf_attachment = NULL, application_datfile_export_date = NULL, date_exported = NULL, application_datfile_name = NULL, application_datfile_batch = NULL, status = 'Not Finalized' WHERE award_no = '".$awardno."'";
                        if(mysqli_query($conn, $updateUnfinalizeAccount)){      
                            unlink($pdf_attachment);         
                        }
                    }
                }                
            }

            //RESIZE IMAGE 
            $max_resolution = 120;

            $front_original_image = imagecreatefromjpeg($db_id_front_photo);
            $back_original_image = imagecreatefromjpeg($db_id_back_photo);

            $front_original_width = imagesy($front_original_image);
            $front_original_height = imagesx($front_original_image);
            $back_original_width = imagesy($back_original_image);
            $back_original_height = imagesx($back_original_image);

            //RESIZE IMAGE -> Front ID
            if($front_original_height > $front_original_width){
                $ratio = $max_resolution / $front_original_height;
                $front_new_height = $max_resolution;
                $front_new_width = $front_original_width * $ratio;
            }
            else{
                $ratio = $max_resolution / $front_original_width;
                $front_new_width = $max_resolution;
                $front_new_height = $front_original_height * $ratio;
            }

            //RESIZE IMAGE -> Back ID
            if($back_original_height > $back_original_width){
                $ratio = $max_resolution / $back_original_height;
                $back_new_height = $max_resolution;
                $back_new_width = $back_original_width * $ratio;
            }
            else{
                $ratio = $max_resolution / $back_original_width;
                $back_new_width = $max_resolution;
                $back_new_height = $back_original_height * $ratio;
            }
        }
    }
    
    
    
    
    //stop processing of exporting pdf if not all necessary field are filled out
    if(empty($db_fname) || empty($db_lname) || empty($db_m_fname) || empty($db_m_lname) || empty($db_birthdate) || empty($db_title) || empty($db_marital_status) || empty($db_birth_place) || empty($db_present_street) || 
    empty($db_present_barangay) || empty($db_present_city) || empty($db_present_province) || 
    empty($db_present_zip) ||empty($db_permanent_street) ||  empty($db_permanent_barangay) ||
    empty($db_permanent_city) ||empty($db_permanent_province) || empty($db_permanent_zip) || 
    empty($db_id_number) || empty($db_id_type) ||
    empty($db_profession) || empty($db_source_of_fund_id) || empty($db_gross_salary_id) || empty($db_tin) || 
    empty($db_contact) || empty($db_email) || empty($db_id_front_photo) || empty($db_id_back_photo) || 
    empty($db_id_expire_date) || $db_id_expire_date == 0000-00-00){
       $msg = "Please fill out all fields with asterisk(*) and click save before exporting to PDF";
       header('location: ../forms.php?errmsg='.$msg);
       exit();
    }
    
    if(empty($db_lbp_branch) && $db_pickup_at_hei == "0"){
        $msg = "Please choose where you want to pick up your LANDBANK Master Card Prepaid Card";
        header('location: ../forms.php?errmsg='.$msg);
        exit();
    }
    
    if($db_pickup_at_hei == "1"){
        $branchName = "";
    }
    elseif($db_pickup_at_hei == "0"){
        $sqlSelectBranch = "SELECT * FROM tbl_lbp_branches WHERE branch_code = '".$db_lbp_branch_code."'"; 
        $resultsqlSelectBranch = mysqli_query($conn, $sqlSelectBranch); 
        $checksqlSelectBranch = mysqli_num_rows($resultsqlSelectBranch);
        if($checksqlSelectBranch > 0){
            while($row = mysqli_fetch_assoc($resultsqlSelectBranch)){
                $branchName = $row['branch_name'];
            }
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
    //$percitymm = str_replace("Ã±","n", $_POST['txt_percitymm']);
    $perprovince = str_replace("Ã±","n", $_POST['txt_perprovince']);
    $perzip = str_replace("Ã±","n", $_POST['txt_perzip']);
    $prestreet = str_replace("Ã±","n", $_POST['txt_prestreet']);
    $prebrgy = str_replace("Ã±","n", $db_present_barangay);
    $precity = str_replace("Ã±","n", $_POST['txt_precity']);
    //$precitymm = str_replace("Ã±","n", $_POST['txt_precitymm']);
    $preprovince = str_replace("Ã±","n", $_POST['txt_preprovince']);
    $prezip = str_replace("Ã±","n", $_POST['txt_prezip']);
    $day = date('Y/m/d');
    $text_day = date("M d, Y", strtotime($day));
    $typeofid_id = str_replace("Ã±","n", $_POST['dd_idtype']); 
    $idnumber = str_replace("Ã±","n", $_POST['txt_idnumber']);
    $prof = str_replace("Ã±","n", $_POST['txt_profession']);
    $sourceoffund = "Other - Stipend";
    $tinnumber = str_replace("Ã±","n", $_POST['txt_tin']);
    $grosssalary_id = str_replace("Ã±","n", $_POST['dd_salary']);
    $grosssalary =  "P30,000 and below";
    $db_emboss_name = str_replace("Ã±","n", $db_emboss_name);

//     $studentFullName = str_replace("Ñ","N", $_POST['txt_lastname']);
//     $studentFullName = str_replace("ñ","n", $_POST['txt_lastname']);
//     $studentFullName = utf8_decode($_POST['txt_lastname']);    
    $studentFullName = $fname.' '.$mname.' '.$lname;
    $studentFullName = utf8_decode($studentFullName);
    $studentFullName = str_replace("Ñ","N", $studentFullName);
    $studentFullName = str_replace("ñ","n", $studentFullName);
    
    if($db_pickup_at_hei == "1"){
        $sqlHEIServicingBranch = "SELECT branch FROM `tbl_lbp_servicing_branches` WHERE hei_uii = '$hei_uii'";
        $resHEIServicingBranch = mysqli_query($conn, $sqlHEIServicingBranch);
        $checkHEIServicingBranch = mysqli_num_rows($resHEIServicingBranch);
        if($checkHEIServicingBranch > 0){
            while($row = mysqli_fetch_assoc($resHEIServicingBranch)){
                $branches = $row['branch'];
                $branches = str_replace("Ã±","n", $branches);
            }
        }
    }
    
    $lname = str_replace('.', '', $lname);
    $fname = str_replace('.', '', $fname);
    $mname = str_replace('.', '', $mname);
    $studentFullName = str_replace('.', '', $studentFullName);
    $mothermaiden = str_replace('.', '', $mothermaiden);
    
    $lname = str_replace('-', '', $lname);
    $fname = str_replace('-', '', $fname);
    $mname = str_replace('-', '', $mname);
    $studentFullName = str_replace('-', '', $studentFullName);
    $mothermaiden = str_replace('-', '', $mothermaiden);
    
    $lname = str_replace('/', '', $lname);
    $fname = str_replace('/', '', $fname);
    $mname = str_replace('/', '', $mname);
    $studentFullName = str_replace('/', '', $studentFullName);
    $mothermaiden = str_replace('/', '', $mothermaiden);
    
    if($branches == '#N/A'){
        $branches = 'N/A';
    }
    
    if($title_char == 'Mr'){
        $titlevalue = 78;
    }
    elseif($title_char == 'Ms'){
        $titlevalue = 75;
    }
    elseif($title_char == 'Mrs'){
        $titlevalue = 81;
    }
        
    $emboss_name = $db_emboss_name;
    
    $supscript1 = '<sup>1</sup>';
    
//REGISTRATION FORM  
    QRcode::png($special_code,"qr.png");
    $pdf = new FPDF('p','mm', array(215.9,330.2));
    $pdf->AddPage();
    $pdf->SetMargins(5,0,0);
    $pdf->SetAutoPageBreak(false,0);
    $pdf->Image("qr.png", 193, 14, 12, 12, "png");

    $pdf->SetFont('Arial', '', 10);
    $pdf->Image('../image/LandbankLogo.png',6,8,8,8);
    $pdf->Cell(5 ,-6 ,'',0,0);
    $pdf->Cell(160 ,0 ,'LANDBANK OF THE PHILIPPINES',0,0);
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->Cell(33 ,4 ,'Exhibit 2',0,1,'R');
    
//     $studentFullName = $fname." ".$mname." ".$lname;

    $str = strtoupper($emboss_name);
    $i = strlen($emboss_name);
    $arr1 = str_split($emboss_name);
    
    $leftPosition = 22.4;
    foreach($arr1 as $i => $r){
        if($arr1[$i] == utf8_decode("ñ") || $arr1[$i] == utf8_decode("Ñ")){
            $pdf->Image('../image/letters/Enye.png',$leftPosition,201.4,5,5);
        }
        elseif($arr1[$i] == " "){
            $pdf->Image('../image/letters/space.png',$leftPosition,201.4,5,5);
        }
        else{
            $pdf->Image('../image/letters/'.strtoupper($arr1[$i]).'.png',$leftPosition,201.4,5,5);     
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
    $pdf->Cell(125,4.27,$studentFullName,'L',0, 'C');
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
    $pdf->Cell(125.3,4.27,utf8_decode($prestreet).', '.utf8_decode($prebrgy).',','LR',0, 'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(28.2,4.27,utf8_decode($prezip) ,'LR',0, 'C');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(125.3,4.27,utf8_decode($precity).', '.utf8_decode($preprovince)  ,'LBR',0, 'C');
    $pdf->Cell(28.2,4.27,"" ,'LBR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(43,4.27,"Place of Birth:" ,'LR',0, 'L');
    $pdf->Cell(46,4.27,"Date of Birth:" ,'LR',0, 'L');
    $pdf->Cell(22.75,4.27,"Nationality:" ,'LR',0, 'L');
    $pdf->Cell(41.75,4.27,"Mother's Maiden Name:" ,'LR',0, 'L');
    $pdf->Cell(51.5,4.27,"" ,'LR',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(43,4.27,utf8_decode($pobirth) ,'LR',0, 'C');
    $pdf->Cell(46,4.27,$text_dobirth ,'LR',0, 'C');
    $pdf->Cell(22.75,4.27,$nationality ,'LR',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(41.75,4.27,utf8_decode($mothermaiden) ,'LR',0, 'C');
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
    $pdf->Cell(30,4.27,"Student ID" ,'LR',0, 'C');
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

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(88.7,4.27,$hei ,'LR',0, 'C');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(28.7,4.27,$mobile ,'LR',0, 'C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(35.9,4.27,utf8_decode($email) ,'LR',0, 'C');
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
    $pdf->Cell(95,4.27,$studentFullName,'LR',0, 'C');
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
    $pdf->Cell(145,4.27,utf8_decode($perstreet).', '.utf8_decode($perbrgy),'LR',0, 'C');
    $pdf->Cell(27,4.27,utf8_decode($perzip) ,'R',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(33,4.27,"the Purchaser" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,utf8_decode($percity).', '.utf8_decode($perprovince) ,'LBR',0, 'C');
    $pdf->Cell(27,4.27,"" ,'BR',0, 'C');
    $pdf->Cell(33,4.27,"" ,'R',1, 'L');

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(145,4.27,"Present Address:" ,'LR',0, 'L');
    $pdf->Cell(27,4.27,"Zip Code:" ,'R',0, 'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(33,4.27,"N/A" ,'LR',1, 'C');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,utf8_decode($prestreet).', '.utf8_decode($prebrgy),'LR',0, 'C');
    $pdf->Cell(27,4.27,utf8_decode($prezip) ,'R',0, 'C');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(33,4.27,"" ,'R',1, 'C');

    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(145,4.27,utf8_decode($precity).', '.utf8_decode($preprovince) ,'LBR',0, 'C');
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

    //downloadable file
    //$pdf->output('D', $studentFullName.' - LandBank Form ('.$day.').pdf');
   
    //saved pdf file to server
    $filename="../pdf/forms/".$GLOBALawardeenumber."_PrepaidRegistrationForm.pdf";
    $pdf->Output($filename,'F');



//ID

    $id_pdf = new FPDF('p','mm', array(215.9,330.2));
    $id_pdf->AddPage();
    $id_pdf->SetMargins(5,0,0);
    $id_pdf->SetAutoPageBreak(false,0);

    $id_pdf->SetFont('Arial', '', 15);
    $id_pdf->Cell(160 ,0 ,$GLOBALawardeenumber.'-'.$studentFullName,0,0,'L');

   // $id_pdf->Image($db_id_front_photo,20,30);
   // $id_pdf->Image($db_id_back_photo,20,180);
   $id_pdf->Image($db_id_front_photo,20,30,$front_new_height,$front_new_width);
   $id_pdf->Image($db_id_back_photo,20,180,$back_new_height,$back_new_width);

    $id_filename="../pdf/IDs/".$GLOBALawardeenumber."_ID.pdf";
    $id_pdf->Output($id_filename,'F');

    // $id_pdf->output('D', $studentFullName.' - ID ('.$day.').pdf');


    //UPDATE editable_fields column
    $sqlUpdateEF = "UPDATE tbl_lbp_form SET editable_fields = 'NO', remarks = NULL WHERE award_no = '$GLOBALawardeenumber'";
    mysqli_query($conn, $sqlUpdateEF);


    // MERGE FORM AND ID PDF

    $merge = new FPDF_Merge();
    $merge->add('../pdf/forms/'.trim($GLOBALawardeenumber).'_PrepaidRegistrationForm.pdf');
    $merge->add('../pdf/IDs/'.trim($GLOBALawardeenumber).'_ID.pdf');
    $merge->output('../pdf/Merged/'.trim($GLOBALawardeenumber).'.pdf','F');
    
    unlink('../pdf/forms/'.trim($GLOBALawardeenumber).'_PrepaidRegistrationForm.pdf');
    unlink('../pdf/IDs/'.trim($GLOBALawardeenumber).'_ID.pdf');
    
    $sqlPDFLocation = "UPDATE tbl_lbp_form SET pdf_attachment = '../pdf/Merged/".$GLOBALawardeenumber.".pdf', status = 'Finalized' WHERE award_no = '$GLOBALawardeenumber'";
    mysqli_query($conn, $sqlPDFLocation);

    // SAVE Contact Details to TES Database
    $concat_ac_year = $GLOBAL_ac_year;
    $concat_ac_year = str_replace('-', '_', $concat_ac_year);

    $updateTESDBContactDetails = "UPDATE tbl_tes_app_$concat_ac_year SET contact = '$mobile' AND email = '$email' WHERE award_no = '$GLOBALawardeenumber'";
    echo $updateTESDBContactDetails;
    // mysqli_query($conn, $updateTESDBContactDetails);

    header('location: ../forms.php');
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
