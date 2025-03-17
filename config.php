
<?php
$username="root";
$password="";
$server='localhost';
$db='20';
$con = mysqli_connect($server,$username,$password,$db);
if($con)
{
    ?>
    <script>
        // alert ('connection sucessfull');
        </script>
        <?php
}else{
    die ("no connection" . mysqli_connect_error());
}
?>