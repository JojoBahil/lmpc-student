<html>

<?php
    include("dbconn.php");
    header("Content-Type:text/html; charset=ISO-8859-1");
    
    $sqlProvZip = "SELECT city FROM tbl_towns WHERE town ='".$_POST["town"]."' LIMIT 1";
    $result = mysqli_query($conn, $sqlProvZip);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
?>
        <input class="form-control" id="txt_precitymm" name="txt_precitymm" type="text" value="<?php echo $row['city']; ?>" readonly="">
<?php
        }
    }
    else{
?>
        <input class="form-control" id="txt_precitymm" name="txt_precitymm" type="text" value="" readonly="">        
<?php
    }
 

?>

</html>