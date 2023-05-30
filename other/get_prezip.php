<html>

<?php
    include("dbconnect.php");
    header("Content-Type:text/html; charset=ISO-8859-1");
    
    $sqlProvZip = "SELECT zipcode FROM tbl_towns WHERE town ='".$_POST["town"]."' AND province = '".$_POST['province']."' AND province <> 'METRO MANILA' LIMIT 1 ";
    $result = mysqli_query($conn, $sqlProvZip);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
?>
        <input class="form-control" id="txt_prezip" name="txt_prezip" type="text" value="<?php echo $row['zipcode']; ?>">
<?php
        }
    }
    else{
?>
        <input class="form-control" id="txt_prezip" name="txt_prezip" type="text" value="">        
<?php
    }
 

?>

</html>
