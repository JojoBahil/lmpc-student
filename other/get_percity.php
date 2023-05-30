<html>

<?php
    include("dbconnect.php");
    header("Content-Type:text/html; charset=ISO-8859-1");
    
    if($_POST['province'] == 'METRO MANILA'){
        $sqlProv = "SELECT city_name FROM tbl_towns_mm WHERE province ='".$_POST["province"]."'";
    }
    elseif($_POST['province'] != 'METRO MANILA'){
        $sqlProv = "SELECT town FROM tbl_towns WHERE province ='".$_POST["province"]."'";
    }
    
    $result = mysqli_query($conn, $sqlProv);
    $resultCheck = mysqli_num_rows($result);
    echo "<option></option>";
    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
?>
        <option><?php if($_POST['province'] == 'METRO MANILA'){echo $row['city_name'];}elseif($_POST['province'] != 'METRO MANILA'){echo $row['town'];} ?></option>
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
