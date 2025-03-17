<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
    		header("location: principal.php");
    		exit;
	}
    $did=$_SESSION["leave_id"];
    
    include("config.php");
	$uname=$_SESSION["id"];
    echo $uname;
    $sql = "SELECT emp_id FROM employee WHERE username='$uname'";
	$result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result); 
    $emp_id=$row["emp_id"];
    $_SESSION["eid"]=$emp_id;
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
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fas fa-user-secret me-2"></i>FACULTY</div>
            <div class="list-group list-group-flush my-3">
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>My Profile</a>
                <a href="leavetype.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-project-diagram me-2"></i>Apply Leave</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-chart-line me-2"></i>View Leave History</a>         
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
                    <h2 class="fs-2 m-0">My Profile</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                                <?php
                                    include 'config.php';
                                    $selectquery = " select emp_name from employee where username='$uname';";
                                    $query = mysqli_query($con,$selectquery);
                                    $num=mysqli_num_rows($query);
                                    $res = mysqli_fetch_array($query);
                                    echo $res['emp_name'];
                                    ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                               
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

	    <div class="container-fluid px-4">
		<div class="single-table">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">                    
                    <tbody>
                        <?php
                            include 'config.php';
                            $sql ="select se.emp_name,se.emp_id,se.username,se.email,se.role,se.department,se.contact_number,se.age,se.gender,lv.leave_id,lv.end_date,lv.start_date,lv.applied_on,lv.leave_status,lt.leave_name from employee se,leaves lv,leavetype lt where se.emp_id=lv.emp_id and lv.leave_type_id=lt.leave_type_id and where se.username='$uname'";
                            
                            $query = mysqli_query($con,$sql);
                            $num=mysqli_num_rows($query);
                            $res = mysqli_fetch_array($query);       
                        ?>
                        <tr>
                            <th>Employee ID:</th>
                            <td colspan="1"><?php echo $res['emp_id'];?></td>
						    <th>Employee Name:</th>
                            <td colspan="1"><?php echo $res['emp_name'];?></td>
                            <th>Gender :</th>
                            <td colspan="1"><?php echo $res['gender'];?></td>
                        </tr>
                        <tr>
						    <th>Age:</th>
                            <td colspan="1"><?php echo $res['age'];?></td>
					        <th>Employee Contact:</th>
                            <td colspan="1"><?php echo $res['contact_number'];?></td>
                            <th>Email Id:</th>
                            <td colspan="1"><?php echo $res['email'];?></td>
					    </tr>
                        <tr>
                            <th>Department:</th>
                            <td colspan="1"><?php echo $res['department'];?></td>
                            <th>Designation:</th>
                            <td colspan="1"><?php echo $res['role'];?></td>
						    <th>Leave ID:</th>
                            <td colspan="1"><?php echo $res['leave_id'];?></td>
                        </tr>
                        <tr>
                            <th>Leave_Name:</th>
                            <td colspan="1"><?php echo $res['leave_name'];?></td>
                            <th>Leave Start Date:</th>
                            <td colspan="1"><?php echo $res['start_date'];?></td>
						    <th>Leave End Date:</th>
                            <td colspan="1"><?php echo $res['end_date'];?></td>

                        </tr> 
                        <tr>
                            <th>Applied On:</th>
                            <td colspan="1"><?php echo $res['applied_on'];?></td>
                            <th>Leave Status:</th>
                            <td colspan="1"><?php echo $res['leave_status'];?></td>
						    
                            
                        </tr> 

                        


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
        $sqll ="SELECT earned_leaves,halfpay_leaves,casual_leaves from employee where username='$uname'";
        $query = mysqli_query($con,$sqll);
        $num=mysqli_num_rows($query);
        $data = array();
        for ($x = 0; $x < $num; $x++) 
        {
            $data[] = mysqli_fetch_assoc($query);
        }
        //$res = mysqli_fetch_array($query);
        echo json_encode($data);
        mysqli_close($con);
    ?>       
    <div id="container"></div>
    <script>
    anychart.onDocumentReady(function () {
      anychart.data.loadJsonFile("php/data.php", function (data) {
        // create a chart and set loaded data
        chart = anychart.bar(data);
        chart.container("container");
        chart.draw();
      });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>
</html>