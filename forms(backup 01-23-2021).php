<?php
    include('navigation.php');
    include('other/dbconnect.php');
    //header("Content-Type:text/html; charset=ISO-8859-1");

    if(!$_SESSION['awardeenumber']){
        header('location: index.php');
    }
    else{
        $GLOBALAwardeeNumber = $_SESSION['awardeenumber'];
    }
    
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TES - LANDBANK Form</title>
        <script src="assets/js/jquery.min.js"></script>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/styles.css?ver=2.0">
        <link rel="stylesheet" href="assets/css/dropdown.css">
        <link rel="stylesheet" href="assets/css/croppie.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
    </head>
    <script type = "text/javascript" src="assets/jquery-3.3.1.js"></script>

   <script>   
        function getLocation(val){
            $.ajax({
                type: "POST",
                url: "other/get_branch.php",
                data: "branch_region=" +val,
                success: function(data){
                    $("#dd_branches").html(data);
                }
            });
        }

        function getCity(valProvince){
            $.ajax({
                type: "POST",
                url: "other/get_precity.php",
                data: "province=" +valProvince,
                success: function(data){
                    $("#txt_precity").html(data);
                }
            });
        }
        function getCityMM(valCityMM){
            $.ajax({
                type: "POST",
                url: "other/get_precitymm.php",
                data: "town=" +valCityMM,
                success: function(data){
                    $("#div_precitymm").html(data);
                }
            });
        }
        function getZip(valCity){
            $.ajax({
                type: "POST",
                url: "other/get_prezip.php",
                data: {town: $('#txt_precity').val(), province: $('#txt_preprovince').val()},
                success: function(data){
                    $("#div_prezip").html(data);
                }
            });
        }
        function getPermanentCity(valProvince){
            $.ajax({
                type: "POST",
                url: "other/get_percity.php",
                data: "province=" +valProvince,
                success: function(data){
                    $("#txt_percity").html(data);
                }
            });
        }
        function getPermanentCityMM(valCityMM){
            $.ajax({
                type: "POST",
                url: "other/get_percitymm.php",
                data: "town=" +valCityMM,
                success: function(data){
                    $("#div_percitymm").html(data);
                }
            });
        }
        function getPermanentZip(valCity){
            $.ajax({
                type: "POST",
                url: "other/get_perzip.php",
                data: {town: $('#txt_percity').val(), province: $('#txt_perprovince').val()},
                success: function(data){
                    $("#div_perzip").html(data);
                }
            });
        }


    // Restrict user input in a text field
      
      var digitsOnly = /[1234567890]/g;
      var integerOnly = /[0-9\.]/g;
      var alphaOnly = /[A-Za-z]/g;
      var usernameOnly = /[0-9A-Za-z\._-]/g;
  
      function restrictInput(myfield, e, restrictionType, checkdot){
          if (!e) var e = window.event
          if (e.keyCode) code = e.keyCode;
          else if (e.which) code = e.which;
          var character = String.fromCharCode(code);
  
          // if user pressed esc... remove focus from field...
          if (code==27) { this.blur(); return false; }  
          
          if (!e.ctrlKey && code!=9 && code!=8 && code!=36 && code!=37 && code!=38 && (code!=39 || (code==39 && character=="'")) && code!=40) {
              if (character.match(restrictionType)) {
                  if(checkdot == "checkdot"){
                      return !isNaN(myfield.value.toString() + character);
                  } else {
                      return true;
                  }
              } else {
                  return false;
              }
          }
      }
    </script>

    <body style="background-image:url('image/background2.png');background-attachment: fixed; background-position: center;">
        <?php
            $awardeenum = $_SESSION['awardeenumber'];

            $sql = "SELECT * FROM vw_complete_teslbp_data_2020_2021 WHERE award_no = '$awardeenum'";
            $results = mysqli_query($conn, $sql);
            $resCheck = mysqli_num_rows($results);

            if($resCheck == 1){
                while($row=mysqli_fetch_array($results)){
                    $db_app_id = mysqli_real_escape_string($conn, $row['app_id']);
                    $db_award_no = mysqli_real_escape_string($conn, $row['award_no']);
                    $db_ac_year = mysqli_real_escape_string($conn, $row['ac_year']);
                    $db_fname = mysqli_real_escape_string($conn, $row['fname']);
                    $db_lname = mysqli_real_escape_string($conn, $row['lname']);
                    $db_mname = mysqli_real_escape_string($conn, $row['mname']);
                    $db_title = mysqli_real_escape_string($conn, $row['title']);
                    $db_marital_status = mysqli_real_escape_string($conn, $row['marital_status']);
                    $db_gender = mysqli_real_escape_string($conn, $row['sex']);
                    $db_dobirth = mysqli_real_escape_string($conn, $row['birthdate']);
                    $db_m_fname = mysqli_real_escape_string($conn, $row['m_fname']);
                    $db_m_mname = mysqli_real_escape_string($conn, $row['m_mname']);
                    $db_m_lname = mysqli_real_escape_string($conn, $row['m_lname']);
                    $db_mothermaiden = $db_m_fname." ".$db_m_mname." ".$db_m_lname;
                    $db_hei_uii = mysqli_real_escape_string($conn, $row['hei_uii']);
                    $db_birth_place = mysqli_real_escape_string($conn, $row['birth_place']);
                    $db_s_mobile = mysqli_real_escape_string($conn, $row['contact']);
                    $db_s_email = mysqli_real_escape_string($conn, $row['email']);
                    $db_permanent_street = mysqli_real_escape_string($conn, $row['permanent_street']);
                    $db_permanent_barangay = mysqli_real_escape_string($conn, $row['permanent_barangay']);
                    $db_permanent_city = mysqli_real_escape_string($conn, $row['permanent_city']);
                    //$db_permanent_citymm = mysqli_real_escape_string($conn, $row['permanent_citymm']);
                    $db_permanent_province = mysqli_real_escape_string($conn, $row['permanent_province']);
                    $db_permanent_zip = mysqli_real_escape_string($conn, $row['permanent_zip']);
                    $db_present_street = mysqli_real_escape_string($conn, $row['present_street']);
                    $db_present_barangay = mysqli_real_escape_string($conn, $row['present_barangay']);
                    $db_present_city = mysqli_real_escape_string($conn, $row['present_city']);
                    //$db_present_citymm = mysqli_real_escape_string($conn, $row['present_citymm']);
                    $db_present_province = mysqli_real_escape_string($conn, $row['present_province']);
                    $db_present_zip = mysqli_real_escape_string($conn, $row['present_zip']);
                    $db_contact = mysqli_real_escape_string($conn, $row['contact']);
                    $db_email = mysqli_real_escape_string($conn, $row['email']);
                    $db_lbp_branch_region = mysqli_real_escape_string($conn, $row['lbp_branch_region']);
                    $db_lbp_branch = mysqli_real_escape_string($conn, $row['lbp_branch']);
                    $db_id_number = mysqli_real_escape_string($conn, $row['id_number']);
                    $db_id_type = mysqli_real_escape_string($conn, $row['id_type']);
                    $db_emboss_name = mysqli_real_escape_string($conn, $row['emboss_name']);
                    $db_profession = mysqli_real_escape_string($conn, $row['profession']);
                    $db_source_of_fund_id = mysqli_real_escape_string($conn, $row['source_of_fund_id']);
                    $db_gross_salary_id = mysqli_real_escape_string($conn, $row['gross_salary_id']);
                    $db_tin = mysqli_real_escape_string($conn, $row['tin']);
                    $db_nationality = mysqli_real_escape_string($conn, $row['nationality']);
                    $db_photo = mysqli_real_escape_string($conn, $row['photo']);
                    $db_id_front_photo = mysqli_real_escape_string($conn, $row['id_front_photo']);
                    $db_id_back_photo = mysqli_real_escape_string($conn, $row['id_back_photo']);
                    $db_editable_fields = mysqli_real_escape_string($conn, $row['editable_fields']);
                    $db_pdf_attachment = mysqli_real_escape_string($conn, $row['pdf_attachment']);
                    $db_expirydate = mysqli_real_escape_string($conn, $row['id_expire_date']);
                    $db_pickup_at_hei = mysqli_real_escape_string($conn, $row['pickup_at_hei']);
                    
                    if($db_m_mname == 'N/A' || $db_m_mname == 'n/a'){
                        $db_m_mname = '';
                    }
                    
                    $db_fname = str_replace('.', '', $db_fname);
                    $db_lname = str_replace('.', '', $db_lname);
                    $db_mname = str_replace('.', '', $db_mname);
                    $db_mothermaiden = str_replace('.', '', $db_mothermaiden);
                }    
                               
            }

        ?>
        
        <div>
            <div class="container" style="background-color:rgba(255,255,255,0.9); color:#696969; padding-bottom:20px; border-radius:7px;">
            <form action = "other/functions.php" method = "POST" style="width:303.328;" enctype="multipart/form-data">
                    <div>
                        <div class='form-row' style='padding-top:10px;'>
                            <div class='col'>
                            </div>
                        </div>
                        <!-- DISPLAY ERROR OR SUCCESS MESSAGE -->
                            <div class="form-row">
                                <div class="col">                                
                                    <?php
                                        if($db_pdf_attachment){
                                            $pdf_attachment = substr($db_pdf_attachment,3);
                                            echo "<div class='form-row' style='background-color:#FEEFB3;text-align:center;border-radius:7px;padding-top:10px;padding-bottom:10px;'>
                                                <div class='col'>
                                                    <span style='color:#9F6000;font-size:20px;'>
                                                        You already finalized your information. You can view the Generated Form from <a href='$pdf_attachment' target='_blank'>here</a>
                                                    </span>
                                                </div>
                                            </div>";
                                        }

                                        if(isset($_GET['errmsg'])){
                                            echo "<div class='form-row' style='background-color:#FFD2D2;text-align:center;border-radius:7px;'><div class='col'><span style='color:#D8000C;'>".$_GET['errmsg']."</span></div></div>";
                                        }
                                        if(isset($_GET['sucmsg'])){
                                            echo "<div class='form-row' style='background-color:#DFF2BF;text-align:center;border-radius:7px;'><div class='col'><span style='color:#4F8A10;'>".$_GET['sucmsg']."</span></div></div>";
                                        }
                                    ?>
                                </div>
                            </div><br><br>
                            <div class="form-row h4titles" style="margin-top:-30px;"><h4><b>LANDBANK Branch</b></h4></div>
                            <div class="form-row">                                                           
                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                    <div class="pickupdiv">
                                        <?php
                                            $sqlheiname = "SELECT hei_name FROM tbl_heis WHERE hei_uii = '$db_hei_uii'";
                                            $resultsqlheiname = mysqli_query($conn, $sqlheiname);
                                            $checksqlheiname = mysqli_num_rows($resultsqlheiname);
                                            while($row=mysqli_fetch_assoc($resultsqlheiname)){
                                                $hei_name=$row['hei_name'];
                                            }   
                                        ?>
                                        <input type='checkbox' name='chk_pickup_at_hei' class='chk_pickup_at_hei' <?php if($db_pickup_at_hei == "1"){ echo 'checked';}?>> I want to pick up my LANDBANK Mastercard Prepaid Card at <?php echo $hei_name; ?>
                                    </div>   <br>
                                    <div class="locationdiv">
                                        <div><label>Region</label></div>
                                       
                                        <select class="dd_location" name="dd_location" id="dd_location" OnChange="getLocation(this.value)" <?php if($db_pickup_at_hei == 1){echo "disabled";}else{echo "";} ?>>
                                            <?php                 
                                                if($db_lbp_branch_region){
                                                    echo "<option>$db_lbp_branch_region</option>";
                                                }       
                                                echo "<option>Select Region</option>";
                                                $sql = "SELECT DISTINCT(region) FROM tbl_lbp_branches ORDER BY region";
                                                $results = mysqli_query($conn, $sql);
                                                $resultCheck = mysqli_num_rows($results);
                                                if($resultCheck > 0){
                                                    while($row=mysqli_fetch_array($results)){
                                                        $branch_region = mysqli_real_escape_string($conn, $row['region']);
                                                        echo "<option value='".$branch_region."'>".$branch_region."</option>";
                                                    }
                                                }                                        
                                            ?>
                                        </select> <br>
                                    </div><br>
                                    <div class="branchdiv">
                                        <div><label><span style= "color:red">* </span>Branch List</label></div>
                                        <select class="dd_branches" name="dd_branches" id="dd_branches" <?php if($db_pickup_at_hei == 1){echo "disabled";}else{echo "";} ?>>
                                        <?php
                                                if($db_lbp_branch){
                                                    $sqlBranchID = "SELECT * FROM tbl_lbp_branches WHERE branch_name = '".$db_lbp_branch."'";
                                                    $resultsqlBranchID = mysqli_query($conn, $sqlBranchID);
                                                    $checksqlBranchID = mysqli_num_rows($resultsqlBranchID);
                                                    while($row=mysqli_fetch_assoc($resultsqlBranchID)){
                                                        $branchID = $row['uid'];
                                                    }
                                                    echo "<option value='$branchID'>".$db_lbp_branch."</option>";
                                                }
                                                else{
                                                    echo "<option>Select your most accessible branch</option>";
                                                }
                                            ?> 
                                        </select> <br>                    
                                        <a target="_blank" href='https://www.landbank.com/find-us'>See detailed branch reference here</a> 
                                    </div>
                                    <br>
                                </div>
                            <!-- end of the form-row -->

                        </div>
                    </div>
                    <div></div>
                    <div>
                    <br><br> <hr> 
                        <div class="form-group">
                            <div class="form-row h4titles"><h4><b>Personal Information</b></h4></div>

                            <div class="form-row">
                                <div class="col-xl-4 col-lg-4" style='background-color:#eee;margin-bottom:15px;'>
                                    <div class="row">
                                        <div class="col" style='padding-top:10px;margin-top:10px;'>
                                            <div style='text-align:center' id='uploaded_image'>
                                                <?php
                                                    if($db_photo){
                                                        $path = substr($db_photo, 3);
                                                        echo "<img src = '$path' alt = 'Please upload your photo' width = '230' height = '230' style='border: 3px solid #fbfbfb; border-radius: 4px; padding: 5px; border-style: outset; box-shadow: 10px 10px 8px #888888;'><br>";
                                                    }
                                                    else{
                                                        echo "<img src = 'image/studentupload/default-blank.png' alt = 'Please upload your photo' width = '230' height = '230' style='border: 3px solid #fbfbfb; border-radius: 4px; padding: 5px; border-style: outset; box-shadow: 10px 10px 8px #888888;'><br>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style='background-color:#ddd;margin-left:-5px;margin-right:-5px;margin-top:29px;'>
                                        <div class="col" style='padding-top:10px;'>
                                            <div>
                                                <div>
                                                    <input type="file" <?php if(!empty($db_photo)){echo "hidden";} ?> name="file_photo" id="file_photo" class="btn file_photo" accept="image/jpeg" <?php if($db_editable_fields == "NO"){echo "disabled";} ?>>
                                                    <input type="button" <?php if(empty($db_photo)){echo "hidden";} ?> name="btn_changephoto" id="btn_changephoto" class="btn btn-warning btn_changephoto" value="Change Image" <?php if($db_editable_fields == "NO"){echo "disabled";} ?>>
                                                </div>
                                                <div style="padding-top:10px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-8">
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col">
                                                <div><label>Award Number</label></div>
                                                <div><input class="form-control" type="text" name="txt_lastname" readonly="" value="<?php echo $GLOBALAwardeeNumber; ?>"></div>
                                            </div>
                                            <!--<div class="col">
                                             <div><label>Full Name</label></div>
                                                <div><input class="form-control" type="text" name="txt_lastname" readonly="" value="<?php echo $db_fname.' '.$db_mname.' '.$db_lname; ?>" placeholder="Ex. Cruz Jr."></div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col">
                                                <div><label><span style= "color:red">* </span>First Name</label></div>
                                                <input type="text" name="txt_fname" class="form-control txt_fname" id="txt_fname" value="<?php echo $db_fname; ?>">
                                            </div>    
                                            <div class="col">
                                                <div><label><span style= "color:red">* </span>Middle Name</label></div>
                                                <input type="text" name="txt_mname" class="form-control txt_mname" id="txt_mname" value="<?php echo $db_mname; ?>">
                                            </div>  
                                            <div class="col">
                                                <div><label><span style= "color:red">* </span>Last Name</label></div>
                                                <input type="text" name="txt_lname" class="form-control txt_lname" id="txt_lname" value="<?php echo $db_lname; ?>">
                                            </div>                                      
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col">
                                                <div><label>Title</label></div>
                                                <div>
                                                    <select class="dd_title" name="dd_title" id="dd_title">
                                                        <?php 
                                                            if($db_gender == 'Male' || $db_gender == 'MALE'){
                                                                if($db_title){  
                                                                    echo "<option value='".$db_title."'>".$db_title."</option>";
                                                                    echo "<option value=Mr>Mr</option>";
                                                                }
                                                                else{
                                                                    echo "<option value=Mr>Mr</option>";
                                                                }   
                                                            }
                                                            elseif($db_gender == 'Female' || $db_gender == 'FEMALE'){
                                                                if($db_title){  
                                                                    echo "<option value='".$db_title."'>".$db_title."</option>";
                                                                    echo "<option value=Ms>Ms</option>";
                                                                    echo "<option value=Mrs>Mrs</option>";
                                                                }
                                                                else{
                                                                    echo "<option value=Ms>Ms</option>";
                                                                    echo "<option value=Mrs>Mrs</option>";
                                                                }   
                                                            }                                  
                                                        ?>                                                
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div><label>Gender</label></div>
                                                <div><input class="form-control" type="text" name="txt_gender" readonly="" value="<?php echo $db_gender; ?>"></div>
                                            </div>
                                            <div class="col">
                                                <div><label><span style= "color:red">* </span>Date of Birth</label></div>
                                                <div><input class="form-control" type="date" name="txt_dateofbirth" value="<?php echo $db_dobirth; ?>" placeholder="MM/DD/YYYY"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col">
                                                <div><label>Marital Status</label></div>
                                                <div>
                                                    <select class="dd_marital_status" name="dd_marital_status" id="dd_marital_status">
                                                        <?php       
                                                            if($db_marital_status){  
                                                                echo "<option value='".$db_marital_status."'>".$db_marital_status."</option>";
                                                                echo "<option value=Single>Single</option>";
                                                                echo "<option value=Married>Married</option>";                                                                
                                                                echo "<option value=Divorced>Divorced</option>";
                                                            }
                                                            else{
                                                                echo "<option value=Single>Single</option>";
                                                                echo "<option value=Married>Married</option>";                                                              
                                                                echo "<option value=Divorced>Divorced</option>";
                                                            }                                       
                                                        ?>                                                
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div><label>Nationality</label></div>
                                                <div><input class="form-control" name="txt_nationality" type="text" readonly="" value="<?php if($db_nationality){echo $db_nationality;}else{echo "PH";} ?>"></div>
                                            </div>
                                            <div class="col">
                                                <div><label>Profession</label></div>
                                                <div><input class="form-control" type="text" name="txt_profession" readonly="" value="<?php if($db_profession){echo $db_profession;} else{echo "Student";} ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row" style='margin-left:-5px;margin-right:-5px;margin-top:10px;'>
                                    <div class="col-xl-4 col-lg-4" style='padding-top:10px;'>
                                        <div>
                                            <div style="margin-top:-10px;"><label><span style= "color:red">* </span>ID Front Image (2mb max.) <?php if(!empty($db_id_front_photo)){ echo '<b><a href="'.substr($db_id_front_photo,1).'" target="_blank">Attached</a></b>';}else{ echo '';}?></label></div>
                                            <div style="background-color:#ddd;">
                                                <input type="file" <?php if(!empty($db_id_front_photo)){echo "hidden";} ?> name="file_idfront" id="file_idfront" class="btn file_idfront" accept="image/jpeg"  <?php if($db_editable_fields == "NO"){echo "disabled";} ?>>
                                                <input type="button" <?php if(empty($db_id_front_photo)){echo "hidden";} ?> name="btn_changeidfront" id="btn_changeidfront" class="btn btn-warning btn_changeidfront" value="Change Image" <?php if($db_editable_fields == "NO"){echo "disabled";} ?>>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div><label><span style= "color:red">* </span>Place of Birth</label></div>
                                        <div><input class="form-control" name="txt_placeofbirth" type="text" maxlength="50" value="<?php if($resCheck == 1){echo $db_birth_place;}else{echo "";}  ?>"></div>
                                    </div>
                                    <div class="col">
                                        <div><label><span style= "color:red"></span>ID Type</label></div>
                                        <div>
                                            <input type="text" class="dd_idtype" name="dd_idtype" id="dd_idtype" value="Student ID" readonly="">
                                                <?php
                                                    // $sqlSelectIDTypeName = "SELECT * FROM tbl_lbp_id_type WHERE id_type = '$db_id_type'";
                                                    // $resultsqlSelectIDTypeName = mysqli_query($conn, $sqlSelectIDTypeName);
                                                    // $resultChecksqlSelectIDTypeName = mysqli_num_rows($resultsqlSelectIDTypeName);         
                                                    // if($db_id_type){                                                    

                                                    //     if($resultChecksqlSelectIDTypeName > 0){
                                                    //         while($row=mysqli_fetch_assoc($resultsqlSelectIDTypeName)){
                                                    //             echo "<option value='".$db_id_type."'>".$row['id_type_name']."</option>";
                                                    //         }
                                                    //     } 
                                                    //     $sqlSelectIDTypeNameOther = "SELECT * FROM tbl_lbp_id_type WHERE id_type != '$db_id_type'";
                                                    //     $resultsqlSelectIDTypeNameOther = mysqli_query($conn, $sqlSelectIDTypeNameOther);
                                                    //     $resultChecksqlSelectIDTypeNameOther = mysqli_num_rows($resultsqlSelectIDTypeNameOther);
                                                    //     if($resultChecksqlSelectIDTypeNameOther > 0){
                                                    //         while($row = mysqli_fetch_assoc($resultsqlSelectIDTypeNameOther)){
                                                    //             echo "<option value = '".$row['id_type']."'>".$row['id_type_name']."</option>";
                                                    //         }
                                                    //     }
                                                    // }
                                                    // else{
                                                    //     $sqlSelectIDTypeName = "SELECT * FROM tbl_lbp_id_type";
                                                    //     $resultsqlSelectIDTypeName = mysqli_query($conn, $sqlSelectIDTypeName);
                                                    //     $resultChecksqlSelectIDTypeName = mysqli_num_rows($resultsqlSelectIDTypeName); 
                                                    //     if($resultChecksqlSelectIDTypeName > 0){
                                                    //         while($row = mysqli_fetch_assoc($resultsqlSelectIDTypeName)){
                                                    //             echo "<option value = '".$row['id_type']."'>".$row['id_type_name']."</option>";
                                                    //         }
                                                    //     }
                                                    //     else{
                                                    //         echo "<option>No Available ID Type</option>";
                                                    //     }
                                                    // }
                                                        // echo "<option value = '02'>Student ID</option>";
                                                                                         
                                                ?>                                                
                                        
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div><label><span style= "color:red">* </span>ID Number</label></div>
                                        <div><input class="form-control" name="txt_idnumber" type="text" value="<?php if($resCheck == 1){echo $db_id_number;}else{echo "";}  ?>"></div>
                                    </div>
                                    <!-- <div class="col">
                                        <div><label><span style= "color:red">* </span>ID Expiry Date</label></div>
                                        <div><input class="form-control" name="txt_expirydate" class="txt_expirydate" type="date" value="<?php if($resCheck == 1){echo $db_expirydate;}else{echo "";}  ?>"></div>
                                    </div> -->
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row" style='margin-left:-5px;margin-right:-5px;margin-top:20px;'>
                                    <div class="col-xl-4 col-lg-4" style='padding-top:10px;'>
                                        <div>
                                            <div style="margin-top:-10px;"><label><span style= "color:red">* </span>ID Back Image (2mb max.) <?php if(!empty($db_id_back_photo)){ echo '<b><a href="'.substr($db_id_back_photo,1).'" target="_blank">Attached</a></b>';}else{ echo '';}?></label></div>
                                            <div style="background-color:#ddd;">
                                                <input type="file" <?php if(!empty($db_id_back_photo)){echo "hidden";} ?> name="file_idback" id="file_idback" class="btn file_idback" accept="image/x-png,image/jpeg"  <?php if($db_editable_fields == "NO"){echo "disabled";} ?>>
                                                <input type="button" <?php if(empty($db_id_back_photo)){echo "hidden";} ?> name="btn_changeidback" id="btn_changeidback" class="btn btn-warning btn_changeidback" value="Change Image" <?php if($db_editable_fields == "NO"){echo "disabled";} ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div><label><span style= "color:red">* </span>TIN</label></div>
                                        <div><input class="form-control" name="txt_tin" placeholder = "Type N/A if none" type="text" value="<?php if($resCheck == 1){echo $db_tin;}else{echo "";}  ?>"></div>
                                    </div>
                                    <div class="col">
                                        <div><label><span style= "color:red"></span>Source of Fund</label></div>
                                        <div>
                                            <input type="text" class="dd_sourceoffund" name="dd_sourceoffund" id="dd_sourceoffund" value="Stipend" readonly="">
                                            
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div><label><span style= "color:red"></span>Gross Salary</label></div>
                                        <div>
                                            <input type="text" class="dd_salary" name="dd_salary" id="dd_salary" value="P30,000 and below" readonly="">
                                            
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                            
                        </div> 
                    </div>
                        <div class="form-group">
                        <!-- New Field -->
                            <div class="form-row"> 
                                <div class="col-lg-2">
                                    <div><label><span style= "color:red">* </span>Mother's Maiden First Name</label></div>
                                    <div><input class="form-control" name="txt_fmothername" type="text" value="<?php echo $db_m_fname; ?>"></div>
                                </div>
                                <div class="col-lg-2">
                                    <div><label><span style= "color:red">* </span>Mother's Maiden Middle Name</label></div>
                                    <div><input class="form-control" name="txt_mmothername" type="text" value="<?php echo $db_m_mname; ?>"></div>
                                </div>
                                <div class="col-lg-2">
                                    <div><label><span style= "color:red">* </span>Mother's Maiden Last Name</label></div>
                                    <div><input class="form-control" name="txt_lmothername" type="text" value="<?php echo $db_m_lname; ?>"></div>
                                </div>
                                <div class="col-lg-6">
                                    <?php
                                        $sqlheiname = "SELECT hei_name FROM tbl_heis WHERE hei_uii = '$db_hei_uii'";
                                        $resultsqlheiname = mysqli_query($conn, $sqlheiname);
                                        $checksqlheiname = mysqli_num_rows($resultsqlheiname);
                                        while($row=mysqli_fetch_assoc($resultsqlheiname)){
                                            $hei_name=$row['hei_name'];
                                        }
                                    ?>
                                    <div><label>Institution</label></div>
                                    <div><input class="form-control" name="txt_hei" type="text" readonly="" value="<?php echo $hei_name; ?>"></div>
                                </div>
                            </div>
                            <!-- End of New Field -->
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                
                            </div>
                        </div>
                        <div><br><br>
                            <hr>
                            <div class="form-row h4titles"><h4><b>Address</b></h4></div>
                            <fieldset style="border: 1px solid #ddd !important; padding: 0 1.4em 1.4em 1.4em !important; margin: 0 0 1.5em 0 !important; border-radius: 5px;">
                            <legend style="font-size: 1em !important;  text-align: left !important; width:inherit; padding:0 10px; border-bottom:none;">Permanent</legend>
                            <div class="form-group">
                                <div>
                                    <span class="note" style="font-size:12px;color:red;"><i><b>Note: Please make sure that Zip Code is correct</b></i></span><br><br>
                                </div>
                                <div class="form-row">
                                <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Province</label></div>
                                        <div class="div_perprovince" id="div_perprovince">
                                            <select class="txt_perprovince" id="txt_perprovince" name="txt_perprovince" onChange="getPermanentCity(this.value)">
                                                <?php
                                                    if($db_permanent_province){
                                                        echo "<option>".$db_permanent_province."</option>";
                                                        $sqlperprovince = "SELECT DISTINCT(province) FROM tbl_towns";
                                                        $resperprovince = mysqli_query($conn, $sqlperprovince);
                                                        $checkperprovince = mysqli_num_rows($resperprovince);
                                                        if($checkperprovince > 0){
                                                            while($row = mysqli_fetch_assoc($resperprovince)){
                                                                echo "<option>".$row['province']."</option>";
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        echo "<option></option>";
                                                        $sqlperprovince = "SELECT DISTINCT(province) FROM tbl_towns";
                                                        $resperprovince = mysqli_query($conn, $sqlperprovince);
                                                        $checkperprovince = mysqli_num_rows($resperprovince);
                                                        if($checkperprovince > 0){
                                                            while($row = mysqli_fetch_assoc($resperprovince)){
                                                                echo "<option>".$row['province']."</option>";
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Town/City</label></div>
                                        <div class="div_percity" id="div_percity"> 
                                            <select class="txt_percity" id="txt_percity" name="txt_percity" onChange="getPermanentCityMM(this.value); getPermanentZip(this.value);">
                                               <?php
                                                    if($db_permanent_city){
                                                        echo '<option>'.$db_permanent_city.'</option>';
                                                        $sqltown = "SELECT town FROM tbl_towns WHERE province = '$db_permanent_province'";
                                                        $restown = mysqli_query($conn, $sqltown);
                                                        $checktown = mysqli_num_rows($restown);
                                                        if($checktown > 0){
                                                            while($row = mysqli_fetch_assoc($restown)){
                                                                echo '<option>'.$row['town'].'</option>';
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        echo '<option></option>';
                                                    }
                                               ?>
                                            </select>
                                        </div>
                                    </div>                                   
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Barangay</label></div>
                                        <div><input class="form-control" id="txt_perbrgy" type="text" name="txt_perbrgy" placeholder="Brgy/ Village" value="<?php if($resCheck){echo $db_permanent_barangay;}  ?>"></div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>House/Bldg. No, Street</label></div>
                                        <div><input class="form-control" id="txt_perstreet" type="text" name="txt_perstreet" placeholder="No., Street" value="<?php if($resCheck){echo $db_permanent_street;} ?>"></div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1">
                                        <div><label><span style= "color:red">* </span>Zip Code</label></div>
                                        <div class="div_perzip" id="div_perzip"><input class="form-control" id="txt_perzip" name="txt_perzip" type="text" value="<?php if($resCheck){echo $db_permanent_zip;} ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>                
                        </div>
                        <input type='checkbox' name='chk_sameAddress' class='chk_sameAddress' 
                            <?php 
                                if($db_permanent_street == $db_present_street && $db_permanent_barangay == $db_present_barangay && $db_permanent_city && $db_present_city && $db_permanent_province == $db_present_province && $db_permanent_zip == $db_present_zip){
                                    echo "checked";
                                }
                            ?>> My Permanent Address is also my Present Address
                    <div class="present_address">
                        <!-- <div class="form-check"><input name="chkAddress" class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Same with Permanent Address</label></div> -->
                        <fieldset style="border: 1px solid #ddd !important; padding: 0 1.4em 1.4em 1.4em !important; margin: 0 0 1.5em 0 !important; border-radius: 5px;">
                            <legend style="font-size: 1em !important;  text-align: left !important; width:inherit; padding:0 10px; border-bottom:none;">Present</legend>
                            <div class="form-group">
                                <div>
                                    <span class="note" style="font-size:12px;color:red;"><i><b>Note: Please make sure that Zip Code is correct</b></i></span><br><br>
                                </div>
                                <div class="form-row">
                                <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Province</label></div>
                                        <div class="div_preprovince" id="div_preprovince">
                                            <select class="txt_preprovince" id="txt_preprovince" name="txt_preprovince" onChange="getCity(this.value)">
                                                <?php
                                                    if($db_present_province){
                                                        echo "<option>".$db_present_province."</option>";
                                                        $sqlprovince = "SELECT DISTINCT(province) FROM tbl_towns";
                                                        $resprovince = mysqli_query($conn, $sqlprovince);
                                                        $checkprovince = mysqli_num_rows($resprovince);
                                                        if($checkprovince > 0){
                                                            while($row = mysqli_fetch_assoc($resprovince)){
                                                                echo "<option>".$row['province']."</option>";
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        echo "<option></option>";
                                                        $sqlprovince = "SELECT DISTINCT(province) FROM tbl_towns";
                                                        $resprovince = mysqli_query($conn, $sqlprovince);
                                                        $checkprovince = mysqli_num_rows($resprovince);
                                                        if($checkprovince > 0){
                                                            while($row = mysqli_fetch_assoc($resprovince)){
                                                                echo "<option>".$row['province']."</option>";
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Town/City</label></div>
                                        <div class="div_precity" id="div_precity"> 
                                            <select class="txt_precity" id="txt_precity" name="txt_precity" onChange="getCityMM(this.value); getZip(this.value);">
                                               <?php
                                                    if($db_present_city){
                                                        echo '<option>'.$db_present_city.'</option>';
                                                        $sqltown = "SELECT town FROM tbl_towns WHERE province = '$db_present_province'";
                                                        $restown = mysqli_query($conn, $sqltown);
                                                        $checktown = mysqli_num_rows($restown);
                                                        if($checktown > 0){
                                                            while($row = mysqli_fetch_assoc($restown)){
                                                                echo '<option>'.$row['town'].'</option>';
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        echo '<option></option>';
                                                    }
                                               ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Barangay</label></div>
                                        <div><input class="form-control" id="txt_prebrgy" type="text" name="txt_prebrgy" placeholder="Brgy/ Village" value="<?php if($resCheck){echo $db_present_barangay;}  ?>"></div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>House/Bldg. No, Street</label></div>
                                        <div><input class="form-control" id="txt_prestreet" type="text" name="txt_prestreet" placeholder="No., Street" value="<?php if($resCheck){echo $db_present_street;} ?>"></div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1">
                                        <div><label><span style= "color:red">* </span>Zip Code</label></div>
                                        <div class="div_prezip" id="div_prezip"><input class="form-control" id="txt_prezip" name="txt_prezip" type="text" value="<?php if($resCheck){echo $db_present_zip;} ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div>
                        <br>
                        <br>
                        <hr>
                        <div class="form-row h4titles"><h4><b>Contact Information</b></h4></div>
                        <div class="form-group">
                            <div class="form-row">
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                    <div><label><span style="color:red">* </span>Mobile Number <i>(Type the last 10 digits only)</i></label></div>
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1">
                                            <p style="padding-top:5px;"><b>+63</b></p>
                                        </div>
                                        <div class="col-sm-11">
                                            <input class="form-control" type="text" name="txt_mobile" id="txt_mobile" pattern="[0-9]{10,10}" onkeypress="return restrictInput(this, event, digitsOnly, null);"
                                            maxlength="10" value="<?php if($resCheck == 1){echo $db_contact = substr($db_contact,3); $db_contact;}else{echo $db_contact;}  ?>">
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-sm-6">
                                    <div><label><span style="color:red">* </span>Email Address</label></div>
                                    <div><input class="form-control" type="email" name="txt_email" value="<?php if($resCheck == 1){echo $db_email;}else{echo $db_email;}  ?>"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6"></div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <hr>
                        <div>
                            <div class="form-group">
                            <div class="form-row">
                                <div class="col"> 
                                    <div class="form-row h4titles"><h4><b>Emboss</b></h4></div>                           
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xl-2"></div>
                                    <div class="col-xl-8">
                                        <div><label><span style= "color:red">* </span>Emboss Name (<i>maximum of 22 characters</i>)</label></div>
                                        <div><input class="form-control" name="txt_emboss" type="text" maxlength="22" pattern="[a-zA-Z- ]{3,22}" style="text-transform:uppercase; text-align:center; letter-spacing:2px;" value="<?php if($resCheck == 1){echo $db_emboss_name;}else{ echo "";} ?>"></div>
                                    </div>
                                    <div class="col-xl-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col" style="text-align:center"><button class="btn btn-primary save" name="btn_save" type="submit" style="width:110px;margin-right:15px;" <?php if($db_editable_fields == "NO"){echo "disabled";} ?>><i class="fa fa-save" style="margin-right:10px;" ></i>Save</button>
                                <!--<button class="btn btn-success save" type="submit" style="width:110px;" name="btn_export"><i class="fa fa-file-export" style="margin-right:10px;"></i>Export</button>-->
                                <input type="button" class="btn btn-success btn_ view_data btn_export1" value="Finalize" data-toggle="modal" id="btn_export" name="btn_export" data-target="#modal_profile" style="margin-right:10px;width:110px;margin-right:15px;" <?php if($db_editable_fields == "NO"){echo "disabled";} ?> >
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                         include('other/modal_exportwarning.php'); 
                    ?>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function(){  
                $('#btn_export').on('click', function() {
                    $('#exportWarningModal').modal("show"); 
                });
            });   
        </script> 

        <?php include('footer.php');?>

        <script src="assets/js/jquery.min.js"></script>   
        <script src="assets/bootstrap/js/bootstrap.min.js"></script> 
        <script src="assets/js/main.js"></script>
        <script src="assets/js/croppie.js"></script>
    </body>
</html>

<!-- MODAL -->
<?php include('other/modalcropimage.php'); ?>


<script>
    $(document).ready(function(){
        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square' 
            },
            boundary:{
                width: 300,
                height:300
            }
        });

        $(function () {
            $(".chk_pickup_at_hei").click(function () {
                if ($(this).is(":checked")) {
                    $(".dd_location").attr("disabled", "disabled");
                    $(".dd_branches").attr("disabled", "disabled");
                } else{                    
                    $(".dd_location").removeAttr("disabled");
                    $(".dd_branches").removeAttr("disabled");
                }
            });
        });
        
        $('input.chk_sameAddress').change(function(){
            if ($(this).is(':checked')) 
            $('div.present_address').hide(600);
            else 
            $('div.present_address').show(600);
        }).change();

        $('#file_photo').on('change', function(){
            
            var reader = new FileReader();
            
            reader.onload = function(event){
                $image_crop.croppie('bind', {
                    url:event.target.result
                }).then(function(){
                    console.log("jQuery bind complete");
                });
            }
            reader.readAsDataURL(this.files[0]); 
            $('#uploadimageModal').modal('show'); 
        });
        
        $('#file_photo').on("change", function() {
            $('#file_photo').attr('hidden','hidden');
            $('#btn_changephoto').show();
        });
        
        $('#btn_changephoto').on('click', function(){
            $('#file_photo').removeAttr('hidden');
            $('#btn_changephoto').hide();
        });

        $('#btn_changeidfront').on('click', function(){
            $('#file_idfront').removeAttr('hidden');
            $('#btn_changeidfront').hide();
        });

        $('#btn_changeidback').on('click', function(){
            $('#file_idback').removeAttr('hidden');
            $('#btn_changeidback').hide();
        });

        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
            }).then(function(response){
                $.ajax({
                    url:"other/upload.php",
                    type: "POST",
                    data:{"image": response},
                    success:function(data)
                    {
                        $('#uploadimageModal').modal('hide');
                        $('#uploaded_image').html(data);
                        $('#file_photo').val('');
                    }
                });
            })
        });
    });
</script>
<script src="assets/js/all.min.js"></script>

