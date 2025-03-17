<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
    		header("location: emp_dash.php");
    		exit;
	}
    include("config.php");
	$ld=$_POST['appid'];
    $sql="SELECT * from employee where emp_id='$ld'";
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
                <a href="emp_dash.php" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="leavetype.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
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
                    <h2 class="fs-2 m-0">Leave History</h2>
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
                                    $selectquery = " select emp_name from employee where emp_id='$ld'";
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
                <thead>
                                <tr>
                                   
                                    <th scope="col">Leave Id</th>
                                    <th scope="col">Leave Name</th>
                                    <th scope="col">leave Applied on</th>
                                    <th scope="col">Leave Start Date</th>
                                    <th scope="col">Leave End Date</th>
                                    <th scope="col">Leave Leave Status</th>

                                </tr>
                            </thead>                 
                    <tbody>
                        <?php
                            include 'config.php';
                            $sql ="select leave_id,leave_name,applied_on,start_date,end_date,leave_status from leaves ls, leavetype ll, employee ee where ls.leave_type_id=ll.leave_type_id and ls.emp_id=ee.emp_id and ee.emp_id='$ld';";
                            $query = mysqli_query($con,$sql);
                            $num=mysqli_num_rows($query);
                            $res = mysqli_fetch_array($query);       
                        ?>
                        <tr>
                                     <td><?php echo $res['leave_id']; ?></td>
                                    <td><?php echo $res['leave_name']; ?></td>
                                    <td><?php echo $res['applied_on']; ?></td>
                                    <td><?php echo $res['start_date']; ?></td>
                                    <td><?php echo $res['end_date']; ?></td>
                                    <td><?php echo $res['leave_status']; ?></td>
                        </tr>
                        <?php
                                    while($res=mysqli_fetch_array($query)){
                                    ?>
                                    <tr>
                                    <td><?php echo $res['leave_id']; ?></td>
                                    <td><?php echo $res['leave_name']; ?></td>
                                    <td><?php echo $res['applied_on']; ?></td>
                                    <td><?php echo $res['start_date']; ?></td>
                                    <td><?php echo $res['end_date']; ?></td>
                                    <td><?php echo $res['leave_status']; ?></td>
                                    
                                    </tr>
                                    <?php
                                    }
                                    ?>
                        
                    </tbody>
                </table>

            </div>
        </div>
    </div>
           
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