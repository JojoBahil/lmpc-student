<html>

<?php
    include("dbconnect.php");
    header("Content-Type:text/html; charset=ISO-8859-1");
    
    $sqlLocation = "SELECT uid, branch_code, branch_name FROM tbl_lbp_branches WHERE region ='".$_POST["branch_region"]."' AND branch_code IS NOT NULL ORDER BY branch_name";
    $result = mysqli_query($conn, $sqlLocation);
    $resultCheck = mysqli_num_rows($result);
?>
        <option>Select your most accessible branch</option>

<?php
    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
?>
        <option value="<?php echo $row['branch_code']; ?>"><?php echo $row['branch_name']; ?></option>
<?php
        }
    }
    else{
        echo "<option>No branch in this location</option>";
    }
 

?>

</html>
