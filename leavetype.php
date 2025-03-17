<?php
    include("config.php");
    session_start();
    if(isset($_POST['redirect']))
	{
    	$eid=$_SESSION["eid"];
	$sql = "SELECT leaves_applied FROM employee WHERE emp_id='$eid'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
    $_SESSION["eid"]=$eid;
		$leave_id=$eid.($row["leaves_applied"]+1);
		$_SESSION["leave_id"]=$leave_id;
			
            $_SESSION["leave_type"]=$_POST["leave_type"];
	    	header('Location: '.$_POST["leave_type"].'_leave.php');
		
    		exit;
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <!-- <link rel="stylesheet" href="login.css" /> -->
    <script src="https://cdn.anychart.com/releases/8.8.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.8.0/js/anychart-data-adapter.min.js"></script>
    <style type="text/css">
   
    html,
    body,
    #container {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }
    </style>
    <title>Employee Dashboard</title>
</head>
<body>

<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
			<a href="emp_dash.php" class="list-group-item list-group-item-action bg-transparent second-text active">
				<i class="fas fa-user-secret me-2"></i>Dashboard</a></div>
            <div class="list-group list-group-flush my-3">
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>My Profile</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-project-diagram me-2"></i>Apply Leave</a>
                        
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-comment-dots me-2"></i>Holiday List</a>
                
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Leave Apply</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                
            </nav>
    <div class="wrapper">
        <h2></h2>
		<center>
	<form action="" method="post">
	
		<!--emp_id:<input type="text" name="emp_id" required>-->
        <!-- emp id: <input type="text" name="eid"> -->
		<label for="leave type" style="color:black;font-size:30px;"> Plese select leave type: </label>
		<select name="leave_type" style="color:black;font-size:20px;">
			<option value="casual">CASUAL LEAVE</option>
			<option value="onduty">ON-DUTY ABSENCE</option>
			<option value="earned">EARNED LEAVE</option>
			<option value="study">STUDY LEAVE</option>
			<option value="specialstudy">SPECIAL STUDY ABSENCE</option>
			<option value="maternity">MATERNITY LEAVE</option>
            <option value="quarantine">QUARANTINE LEAVE</option>
			<option value="commuted">COMMUTED ABSENCE</option>
			<option value="medical">MEDICAL</option>
            <option value="compensatory">COMPENSATORY LEAVE</option>
            <option value="notdue">LEAVE NOT DUE</option>
			<option value="specialdisability">SPECIAL DISABILITY LEAVE</option>
		</select>

		<br><br>

		<input  style="color:black;font-size:20px;" type="submit" name="redirect" value"Submit">

		
	</form>
	<center>
</body>
</html>