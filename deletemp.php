<?php
include('config.php'); 
$sql = "DELETE FROM employee WHERE emp_id='" . $_GET["emp_id"] . "'";

$run = mysqli_query($con,$sql);

if($run == true){
			
    echo "<script> 
            alert('User Deleted');
            window.open('principal1.php','_self');
          </script>";
}else{
    echo "<script> 
    alert('Failed to delete');
    </script>";
}

mysqli_close($con);
?>