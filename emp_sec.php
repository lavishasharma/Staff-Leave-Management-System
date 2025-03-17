<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
    		header("location: login2.php");
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
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fas fa-user-secret me-2"></i>ADMIN
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="admin_index.php" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Employee Section</h2>
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
                                    $selectquery = " select  se.emp_name,ss.username from employee se,special_role ss where se.emp_id=ss.emp_id; ";
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
                <div class="row my-2">
                    <!-- <h3 class="fs-4 mb-3">ALL Employee</h3> -->
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Employee Id</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Year Of Service</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    include 'config.php';
                                    $selectquery = " select * from employee; ";
                                    $query = mysqli_query($con,$selectquery);
                                    $num=mysqli_num_rows($query);
                                    $res = mysqli_fetch_array($query);
                                    ?>
                                    <tr>
                                    
                                    <td><?php echo $res['emp_id']; ?></td>
                                    <td><?php echo $res['emp_name']; ?></td>
                                    <td><?php echo $res['age']; ?></td>
                                    <td><?php echo $res['gender']; ?></td>
                                    <td><?php echo $res['department']; ?></td>
                                    <td><?php echo $res['role']; ?></td>
                                    <td><?php echo $res['contact_number']; ?></td>
                                    <td><?php echo $res['years_of_service']; ?></td>

                                    </tr>
                                    <?php
                                    while($res = mysqli_fetch_array($query)){
                                    ?>
                                    
                                    <tr>
                                    
                                    <td><?php echo $res['emp_id']; ?></td>
                                    <td><?php echo $res['emp_name']; ?></td>
                                    <td><?php echo $res['age']; ?></td>
                                    <td><?php echo $res['gender']; ?></td>
                                    <td><?php echo $res['department']; ?></td>
                                    <td><?php echo $res['role']; ?></td>
                                    <td><?php echo $res['contact_number']; ?></td>
                                    <td><?php echo $res['years_of_service']; ?></td>

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