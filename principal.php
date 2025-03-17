<?php
	session_start();
   
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
    		header("location: login1.php");
    		exit;
	}
    if(isset($_POST["id"]))
	{
    	
	    	header('location: emp_details.php');
		
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
    <title>Principal Dashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fas fa-user-secret me-2"></i>Principal</div>
            <div class="list-group list-group-flush my-3">
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="emp_sec.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-project-diagram me-2"></i>Employee Section</a>
                <a href="dept.html" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-chart-line me-2"></i>Department Section</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-paperclip me-2"></i>Leave Types</a>
                        
                 <a class="list-group-item list-group-item-action bg-transparent second-text fw-bold" href="#" id="navbarDropdown"
                 role="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-object-ungroup"></i>Manage Leave
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                    <li><a class="dropdown-item" href="#">Approved</a></li>
                                    <li><a class="dropdown-item" href="#">Declined</a></li>
                                    <li><a class="dropdown-item" href="#">Leave History</a></li>

                                </ul>
                            
                        
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-gift me-2"></i>Manage Admin</a>
                        
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
                    <h2 class="fs-2 m-0">Dashboard</h2>
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
                                    // $selectquery = " select  se.emp_name,ss.username from employee se,special_role ss where se.emp_id=ss.emp_id; ";
                                    $selectquery ="select emp_name from employee where desig_id=1";
                                    $query = mysqli_query($con,$selectquery);
                                    $num=mysqli_num_rows($query);
                                    $res = mysqli_fetch_array($query);
                                    echo $res['emp_name'];
                                    ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="reset_pwrd.php">Reset_Password</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            
                <div class="row my-5">
                    <h3 class="fs-4 mb-3">Last 24 hours Leave Status</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                   
                                    <th scope="col">Leave Id</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Leave Type</th>
                                    <th scope="col">Leave Status</th>

                                </tr>
                            </thead>
                            
                            <tbody>

                                    <?php
                                    include 'config.php';
                                    $selectquery = "select lt.leave_id,lt.emp_id,lt.leave_status ,ll.leave_name from leaves lt,leavetype ll where lt.leave_type_id=ll.leave_type_id and leave_status='Pending'";
                                    $query = mysqli_query($con,$selectquery);
                                    $num=mysqli_num_rows($query);
                                    $res = mysqli_fetch_array($query);
                                    ?>
                                    <tr>
                                    
                                    <td><?php echo $res['leave_id']; ?></td>
                                    <td><?php echo $res['emp_id']; ?></td>
                                    <td><?php echo $res['leave_name']; ?></td>
                                    <td><?php echo $res['leave_status']; ?></td>
                                    <td><a href="emp_details.php"><input type="submit" name="vd" value="View Details"></a></td>
                                   
                                   <?php
                                    while($res=mysqli_fetch_array($query)){
                                    ?>
                                    <tr>
                                    <td><?php echo $res['leave_id']; ?></td>
                                   <td><?php echo $res['emp_id']; ?></td>
                                    <td><?php echo $res['leave_name']; ?></td>
                                    <td><?php echo $res['leave_status']; ?></td>
                                    
                                    <td><a href="emp_details.php"><input type="submit" name="vd" value="View Details"></a></td>
                                    
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>

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