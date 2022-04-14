<?php
    include('navigation.php');
    include('other/dbconn.php');
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
    </script>

    <body style="background-image:url('image/background2.png');background-attachment: fixed; background-position: center;">
        <?php
            $awardeenum = $_SESSION['awardeenumber'];

            $sql = "SELECT * FROM vw_complete_teslbp_data WHERE award_no = '$awardeenum'";
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
                    $db_permanent_province = mysqli_real_escape_string($conn, $row['permanent_province']);
                    $db_permanent_zip = mysqli_real_escape_string($conn, $row['permanent_zip']);
                    $db_present_street = mysqli_real_escape_string($conn, $row['present_street']);
                    $db_present_barangay = mysqli_real_escape_string($conn, $row['present_barangay']);
                    $db_present_city = mysqli_real_escape_string($conn, $row['present_city']);
                    $db_present_province = mysqli_real_escape_string($conn, $row['present_province']);
                    $db_present_zip = mysqli_real_escape_string($conn, $row['present_zip']);
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
                    $db_nationality = mysqli_real_escape_string($conn, $row['nationality']);
                    $db_photo = mysqli_real_escape_string($conn, $row['photo']);
                    $db_editable_fields = mysqli_real_escape_string($conn, $row['editable_fields']);
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
                                        if(isset($_GET['errmsg'])){
                                            echo "<div class='form-row' style='background-color:#FFD2D2;text-align:center;border-radius:7px;'><div class='col'><span style='color:#D8000C;'>".$_GET['errmsg']."</span></div></div>";
                                        }
                                        if(isset($_GET['sucmsg'])){
                                            echo "<div class='form-row' style='background-color:#DFF2BF;text-align:center;border-radius:7px;'><div class='col'><span style='color:#4F8A10;'>".$_GET['sucmsg']."</span></div></div>";
                                        }
                                    ?>
                                </div>
                            </div><br><br>
                            <div class="form-row h4titles" style="margin-top:-30px;"><h4><b>Landbank Branch</b></h4></div>
                            <div class="form-row">                                                           
                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">                               
                                    <div class="locationdiv">
                                        <div><label>Region</label></div>
                                        <select class="dd_location" name="dd_location" id="dd_location" OnChange="getLocation(this.value)">
                                            <?php                 
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
                                        
                                        <select class="dd_branches" name="dd_branches" id="dd_branches">
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
                                        <a target="_blank" href='https://www.landbank.com/branch-locator?field_location_tid=39&field_area_tid=All&field_southern_ncr_area_tid=All&field_nluzon_region1_area_tid=All&field_nluzon_region2_area_tid=All&field_central_luzon_area_tid=All&field_southern_luzon_area_tid=All&field_western_visayas_area_tid=All&field_eastern_visayas_area_tid=All&field_western_mindanao_area_tid=All&field_eastern_mindanao_area_tid=All'>See detailed branch reference here</a> 
                                    </div>
                                </div><br>
                                 
                                
                                <div class="col">
                                    <div></div>
                                    <div></div>
                                <div class="col">
                                    <div></div>
                                </div>
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
                                <div class="col-xl-4" style='background-color:#eee;margin-bottom:15px;'>
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
                                                <div><input type="file" name="file_photo" id="file_photo" class="btn file_photo" <?php if($db_editable_fields == "NO"){echo "disabled";} ?>></div>
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
                                            <div class="col">
                                            <div><label>Full Name</label></div>
                                                <div><input class="form-control" type="text" name="txt_lastname" readonly="" value="<?php echo $db_fname.' '.$db_mname.' '.$db_lname; ?>" placeholder="Ex. Cruz Jr."></div>
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
                                                            if($db_gender == 'Male'){
                                                                if($db_title){  
                                                                    echo "<option value='".$db_title."'>".$db_title."</option>";
                                                                    echo "<option value=Mr>Mr</option>";
                                                                }
                                                                else{
                                                                    echo "<option value=Mr>Mr</option>";
                                                                }   
                                                            }
                                                            elseif($db_gender == 'Female'){
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
                                                <div><label>Date of Birth</label></div>
                                                <div><input class="form-control" type="text" name="txt_dateofbirth" readonly="" value="<?php echo date("M d, Y", strtotime($db_dobirth)); ?>" placeholder="MM/DD/YYYY"></div>
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
                                                                echo "<option value=Separated>Separated</option>";
                                                                echo "<option value=Widowed>Widowed</option>";
                                                            }
                                                            else{
                                                                echo "<option value=Single>Single</option>";
                                                                echo "<option value=Married>Married</option>";
                                                                echo "<option value=Separated>Separated</option>";
                                                                echo "<option value=Widowed>Widowed</option>";
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
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col">
                                                <div><label>Mother's Maiden Name</label></div>
                                                <div><input class="form-control" name="txt_mothername" type="text" readonly="" value="<?php echo $db_mothermaiden; ?>"></div>
                                            </div>
                                            <div class="col">
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
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <div><label><span style= "color:red">* </span>Place of Birth</label></div>
                                    <div><input class="form-control" name="txt_placeofbirth" type="text" value="<?php if($resCheck == 1){echo $db_birth_place;}else{echo "";}  ?>"></div>
                                </div>
                                <div class="col">
                                    <div><label><span style= "color:red">* </span>ID Number</label></div>
                                    <div><input class="form-control" name="txt_idnumber" type="text" value="<?php if($resCheck == 1){echo $db_id_number;}else{echo "";}  ?>"></div>
                                </div>
                                <div class="col">
                                    <div><label><span style= "color:red">* </span>ID Type</label></div>
                                    <div>
                                        <select class="dd_idtype" name="dd_idtype" id="dd_idtype">
                                            <?php
                                                $sqlSelectIDTypeName = "SELECT * FROM tbl_lbp_id_type WHERE id_type = '$db_id_type'";
                                                $resultsqlSelectIDTypeName = mysqli_query($conn, $sqlSelectIDTypeName);
                                                $resultChecksqlSelectIDTypeName = mysqli_num_rows($resultsqlSelectIDTypeName);         
                                                if($db_id_type){                                                    

                                                    if($resultChecksqlSelectIDTypeName > 0){
                                                        while($row=mysqli_fetch_assoc($resultsqlSelectIDTypeName)){
                                                            echo "<option value='".$db_id_type."'>".$db_id_type." - ".$row['id_type_name']."</option>";
                                                        }
                                                    } 
                                                    $sqlSelectIDTypeNameOther = "SELECT * FROM tbl_lbp_id_type WHERE id_type != '$db_id_type'";
                                                    $resultsqlSelectIDTypeNameOther = mysqli_query($conn, $sqlSelectIDTypeNameOther);
                                                    $resultChecksqlSelectIDTypeNameOther = mysqli_num_rows($resultsqlSelectIDTypeNameOther);
                                                    if($resultChecksqlSelectIDTypeNameOther > 0){
                                                        while($row = mysqli_fetch_assoc($resultsqlSelectIDTypeNameOther)){
                                                            echo "<option value = '".$row['id_type']."'>".$row['id_type']." - ".$row['id_type_name']."</option>";
                                                        }
                                                    }
                                                }
                                                else{
                                                    $sqlSelectIDTypeName = "SELECT * FROM tbl_lbp_id_type";
                                                    $resultsqlSelectIDTypeName = mysqli_query($conn, $sqlSelectIDTypeName);
                                                    $resultChecksqlSelectIDTypeName = mysqli_num_rows($resultsqlSelectIDTypeName); 
                                                    if($resultChecksqlSelectIDTypeName > 0){
                                                        while($row = mysqli_fetch_assoc($resultsqlSelectIDTypeName)){
                                                            echo "<option value = '".$row['id_type']."'>".$row['id_type']." - ".$row['id_type_name']."</option>";
                                                        }
                                                    }
                                                    else{
                                                        echo "<option>No Available ID Type</option>";
                                                    }
                                                }
                                                                                             
                                            ?>                                                
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <div><label><span style= "color:red">* </span>TIN Number</label></div>
                                    <div><input class="form-control" name="txt_tin" placeholder = "Type N/A if none" type="text" value="<?php if($resCheck == 1){echo $db_tin;}else{echo "";}  ?>"></div>
                                </div>
                                <div class="col">
                                    <div><label><span style= "color:red">* </span>Source of Fund</label></div>
                                    <div>
                                        <select class="dd_sourceoffund" name="dd_sourceoffund" id="dd_sourceoffund">
                                        <?php
                                                $sqlSelectSourceFund = "SELECT * FROM tbl_lbp_source_fund WHERE source_id = '$db_source_of_fund_id'";
                                                $resultsqlSelectSourceFund = mysqli_query($conn, $sqlSelectSourceFund);
                                                $resultChecksqlSelectSourceFund = mysqli_num_rows($resultsqlSelectSourceFund);         
                                                if($db_source_of_fund_id){                                                    

                                                    if($resultChecksqlSelectSourceFund > 0){
                                                        while($row=mysqli_fetch_assoc($resultsqlSelectSourceFund)){
                                                            echo "<option value='".$db_source_of_fund_id."'>".$db_source_of_fund_id." - ".$row['source']."</option>";
                                                        }
                                                    } 
                                                    $sqlSelectSourceFundOther = "SELECT * FROM tbl_lbp_source_fund WHERE source_id != '$db_source_of_fund_id'";
                                                    $resultsqlSelectSourceFundOther = mysqli_query($conn, $sqlSelectSourceFundOther);
                                                    $resultChecksqlSelectSourceFundOther = mysqli_num_rows($resultsqlSelectSourceFundOther);
                                                    if($resultChecksqlSelectSourceFundOther > 0){
                                                        while($row = mysqli_fetch_assoc($resultsqlSelectSourceFundOther)){
                                                            echo "<option value = '".$row['source_id']."'>".$row['source_id']." - ".$row['source']."</option>";
                                                        }
                                                    }
                                                }
                                                else{
                                                    $sqlSelectSourceFundOther = "SELECT * FROM tbl_lbp_source_fund";
                                                    $resultsqlSelectSourceFundOther = mysqli_query($conn, $sqlSelectSourceFundOther);
                                                    $resultChecksqlSelectSourceFundOther = mysqli_num_rows($resultsqlSelectSourceFundOther);
                                                    if($resultChecksqlSelectSourceFundOther > 0){
                                                        while($row = mysqli_fetch_assoc($resultsqlSelectSourceFundOther)){
                                                            echo "<option value = '".$row['source_id']."'>".$row['source_id']." - ".$row['source']."</option>";
                                                        }
                                                    }
                                                    else{
                                                        echo "<option>No Available Source of Fund</option>";
                                                    }
                                                }
                                                                                             
                                            ?>                                                  
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div><label><span style= "color:red">* </span>Gross Salary</label></div>
                                    <div>
                                        <select class="dd_salary" name="dd_salary" id="dd_salary">
                                        <?php
                                                $sqlSelectSalary = "SELECT * FROM tbl_lbp_gross_salary WHERE gsalary_id = '$db_gross_salary_id'";
                                                $resultsqlSelectSalary = mysqli_query($conn, $sqlSelectSalary);
                                                $resultChecksqlSelectSalary = mysqli_num_rows($resultsqlSelectSalary);     

                                                if($db_gross_salary_id){  
                                                    if($resultChecksqlSelectSalary > 0){
                                                        while($row=mysqli_fetch_assoc($resultsqlSelectSalary)){
                                                            echo "<option value='".$db_gross_salary_id."'>".$db_gross_salary_id." - ".$row['salary_range']."</option>";
                                                        }
                                                    } 
                                                    $sqlSelectSalary = "SELECT * FROM tbl_lbp_gross_salary WHERE gsalary_id != '$db_gross_salary_id'";
                                                    $resultsqlSelectSalary = mysqli_query($conn, $sqlSelectSalary);
                                                    $resultChecksqlSelectSalary = mysqli_num_rows($resultsqlSelectSalary);
                                                    if($resultChecksqlSelectSalary > 0){
                                                        while($row = mysqli_fetch_assoc($resultsqlSelectSalary)){
                                                            echo "<option value = '".$row['gsalary_id']."'>".$row['gsalary_id']." - ".$row['salary_range']."</option>";
                                                        }
                                                    }
                                                }
                                                else{
                                                    $sqlSelectSalary = "SELECT * FROM tbl_lbp_gross_salary";
                                                    $resultsqlSelectSalary = mysqli_query($conn, $sqlSelectSalary);
                                                    $resultChecksqlSelectSalary = mysqli_num_rows($resultsqlSelectSalary);
                                                    if($resultChecksqlSelectSalary > 0){
                                                        while($row = mysqli_fetch_assoc($resultsqlSelectSalary)){
                                                            echo "<option value = '".$row['gsalary_id']."'>".$row['gsalary_id']." - ".$row['salary_range']."</option>";
                                                        }
                                                    }
                                                    else{
                                                        echo "<option>No Available Salary Range</option>";
                                                    }
                                                }
                                                                                             
                                            ?>                                                     
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div><br><br>
                            <hr>
                            <div class="form-row h4titles"><h4><b>Address</b></h4></div>
                            <fieldset style="border: 1px solid #ddd !important; padding: 0 1.4em 1.4em 1.4em !important; margin: 0 0 1.5em 0 !important; border-radius: 5px;">
                                <legend style="font-size: 1em !important;  text-align: left !important; width:inherit; padding:0 10px; border-bottom:none;">Permanent</legend>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-xl col-lg col-sm-6">
                                            <div><label>Street</label></div>
                                            <div><input class="form-control" id="txt_perstreet" type="text" readonly="" name="txt_perstreet" placeholder="No., Street" value="<?php echo $db_permanent_street; ?>"></div>
                                        </div>
                                        <div class="col-xl col-lg col-sm-6">
                                            <div><label><span style= "color:red">* </span>Permanent Barangay</label></div>
                                            <div><input class="form-control" id="txt_perbrgy" type="text"  name="txt_perbrgy" placeholder="Brgy/ Village" value="<?php if($resCheck == 1){echo $db_permanent_barangay;}else{echo "";}  ?>"></div>
                                        </div>
                                        <div class="col-xl col-lg col-sm-6">
                                            <div><label>City</label></div>
                                            <div><input class="form-control" id="txt_percity" readonly="" name="txt_percity" type="text" value="<?php echo $db_permanent_city; ?>"></div>
                                        </div>
                                        <div class="col-xl col-lg col-sm-6">
                                            <div><label>Province</label></div>
                                            <div><input class="form-control" id="txt_perprovince" readonly="" name="txt_perprovince" type="text" value="<?php echo $db_permanent_province; ?>"></div>
                                        </div>
                                        <div class="col-xl col-lg col-sm-6">
                                            <div><label>Zip Code</label></div>
                                            <div><input class="form-control" id="txt_perzip" readonly="" name="txt_perzip" type="text" value="<?php echo $db_permanent_zip ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>                        
                        </div>
                    <div>
                        <div class="form-check"><input name="chkAddress" class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Same with Permanent Address</label></div>
                        <fieldset style="border: 1px solid #ddd !important; padding: 0 1.4em 1.4em 1.4em !important; margin: 0 0 1.5em 0 !important; border-radius: 5px;">
                            <legend style="font-size: 1em !important;  text-align: left !important; width:inherit; padding:0 10px; border-bottom:none;">Present</legend>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Street</label></div>
                                        <div><input class="form-control" id="txt_prestreet" type="text" name="txt_prestreet" placeholder="No., Street" value="<?php if($resCheck == 1){echo $db_present_street;}else{echo "";}  ?>"></div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Barangay</label></div>
                                        <div><input class="form-control" id="txt_prebrgy" type="text" name="txt_prebrgy" placeholder="Brgy/ Village" value="<?php if($resCheck == 1){echo $db_present_barangay;}else{echo "";}  ?>"></div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>City</label></div>
                                        <div><input class="form-control" id="txt_precity" name="txt_precity" type="text" value="<?php if($resCheck == 1){echo $db_present_city;}else{echo "";}  ?>"></div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Province</label></div>
                                        <div><input class="form-control" id="txt_preprovince" name="txt_preprovince" type="text" value="<?php if($resCheck == 1){echo $db_present_province;}else{echo "";}  ?>"></div>
                                    </div>
                                    <div class="col-xl col-lg col-sm-6">
                                        <div><label><span style= "color:red">* </span>Zip Code</label></div>
                                        <div><input class="form-control" id="txt_prezip" name="txt_prezip" type="text" value="<?php if($resCheck == 1){echo $db_present_zip;}else{echo "";}  ?>"></div>
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
                                    <div><label><span style="color:red">* </span>Mobile Number</label></div>
                                    <div><input class="form-control" type="number" name="txt_mobile" maxlength="11" value="<?php if($resCheck == 1){echo $db_contact;}else{echo $db_contact;}  ?>"></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-sm-6">
                                    <div><label><span style="color:red">* </span>Email Address</label></div>
                                    <div><input class="form-control" type="text" name="txt_email" value="<?php if($resCheck == 1){echo $db_email;}else{echo $db_email;}  ?>"></div>
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
                                        <div><input class="form-control" name="txt_emboss" type="text" maxlength="22" style="text-transform:uppercase; text-align:center; letter-spacing:2px;" value="<?php if($resCheck == 1){echo $db_emboss_name;}else{ echo "";} ?>"></div>
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
                                <input type="button" class="btn btn-success btn_ view_data btn_export1" value="Export" data-toggle="modal" id="btn_export1" name="btn_export1" data-target="#modal_profile" style="margin-right:10px;width:110px;margin-right:15px;">
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
                $('#btn_export1').on('click', function() {
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

