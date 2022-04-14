<?php
    include('navigation.php');
    include('other/dbconn.php');
    header("Content-Type:text/html; charset=ISO-8859-1");

    if(!$_SESSION['awardeenumber']){
        header('location: index.php');
    }

    $awardeenum = $_SESSION['awardeenumber'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TES - Application Form</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/Footer-Basic.css">
        <link rel="stylesheet" href="assets/css/instruction.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
    </head>
    <body style="background-image:url('image/background2.png');background-attachment: fixed; background-position: center;">
        <div class="container" style="background-color:rgba(255,255,255,0.9); color:#737373; padding-top:20px;  padding-bottom:20px; border-radius:7px;">
            <div class='row'>
                <div class='col' align='center'>
                <h4>Generated Application Form</h4><br>
                    <?php
                        $sqlApplicationForm = "SELECT pdf_attachment FROM tbl_lbp_form WHERE award_no = '$awardeenum'";
                        $resApplicationForm = mysqli_query($conn, $sqlApplicationForm);
                        $checkApplicationForm = mysqli_num_rows($resApplicationForm);
                        if($checkApplicationForm > 0){
                            $row = mysqli_fetch_assoc($resApplicationForm);
                            $db_pdf_attachment =  mysqli_real_escape_string($conn, $row['pdf_attachment']);
                        }
                        $pdf_attachment = substr($db_pdf_attachment,3);
                    ?>
                    <object data="<?php echo $pdf_attachment; ?>" type="application/pdf" width="100%" height="1000px"></object> 
                </div>
            </div>
        </div>
        <?php
            include('footer.php');
        ?>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/all.min.js"></script>
    </body>
</html>