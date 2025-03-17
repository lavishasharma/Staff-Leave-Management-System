<?php
	include'config.php'; 
	if (isset($_POST['approve']))
	{
		$appid = $_POST['appid'];
		$sql = "UPDATE leaves SET leave_status='Approved' WHERE emp_id = '$appid'";
		$run = mysqli_query($con,$sql);
		if($run == true)
		{
			echo "<script> 
					alert('Application Approved');
					window.open('principal1.php','_self');
				  </script>";
		}
		else
		{
			echo "<script> 
			alert('Failed To Approve');
			</script>";
		}
	}
	else
	{
		$appid = $_POST['appid'];
		$sql = "UPDATE leaves SET leave_status='Declined' WHERE emp_id = '$appid'";
		$run = mysqli_query($con,$sql);
		if($run == true)
		{
			echo "<script> 
					alert('Application Declined');
					window.open('principal1.php','_self');
				  </script>";
		}
		else
		{
			echo "<script> 
			alert('Failed To Decline');
			</script>";
		}
	}
 ?>