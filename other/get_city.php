<html>

<?php
    include("dbconn.php");
    header("Content-Type:text/html; charset=ISO-8859-1");
    
    $sqlProv = "SELECT town FROM tbl_towns WHERE province ='".$_POST["province"]."'";
    $result = mysqli_query($conn, $sqlProv);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
?>
        <option><?php echo $row['town']; ?></option>
<?php
        }
    }
    else{
?>
        <option>No town available from database</option>
<?php
    }
 

?>

</html>
