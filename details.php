<?php
    include('config.php');
    session_start();
    error_reporting(0);
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
    		header("location: login1.php");
    		exit;
	}
    else
    {
        if(isset($_POST['update']))
        { 
            // $did=intval($_GET['leave_id']);
            $did=$_GET['leave_id'];
            $status=$_POST['status'];   
            $sql="UPDATE leaves set leave_status='$status' where leave_id='$did'";
            $run = mysqli_query($con,$sql);
            // if($run == true)
            // {
                //$msg="Leave status updated Successfully";
            //}
            if($run == true){
			
                echo "<script> 
                        alert('Leave status updated successfully');
                        window.open('principal1.php','_self');
                      </script>";
            }else{
                echo "<script> 
                alert('Failed to update');
                </script>";
            }
        }
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel - Employee Leave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="./assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/themify-icons.css">
    <link rel="stylesheet" href="./assets/css/metisMenu.css">
    <link rel="stylesheet" href="./assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="./assets/css/typography.css">
    <link rel="stylesheet" href="./assets/css/default-css.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body style="background-color: #C396E9">
    <br><br><h2><center>Leave Details</center></h2>
    <div class="main-content-inner"> 
        <div class="row">
            <div class="col-lg-12 mt-5">

            <?php if($error){?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            
                             </div><?php } 
                                 else if($msg){?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?> 
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                 </div><?php }?>

                <div class="card">
                    <div class="card-body">       
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped text-center">      
                                    <tbody>
                                        <?php 
                                            $lid=$_GET['leave_id'];
                                            $sql = "SELECT leaves.leave_id as lid, leaves.combinations, employee.emp_name,employee.emp_id,employee.gender,employee.contact_number,employee.email,leaves.end_date,leaves.start_date,leaves.applied_on,leaves.leave_status ,leavetype.leave_name from leaves join employee join leavetype on leaves.emp_id=employee.emp_id and leaves.leave_type_id=leavetype.leave_type_id and  leaves.leave_status='Pending'  where leaves.leave_id='$lid'";
                                            $que = mysqli_query($con,$sql);
                                            $cnt=1;
                                            while ($result = mysqli_fetch_assoc($que)) 
                                            {
                                                // foreach($results as $result)
                                                // {
                                        ?>
                                        <tr>
                                            <td ><b>Employee ID:</b></td>
                                            <td colspan="1"><?php echo $result['emp_id'];?></td>
                                            <td> <b>Employee Name:</b></td>
                                            <td colspan="1"><?php echo $result['emp_name'];?></td>
                                            <td ><b>Gender :</b></td>
                                            <td colspan="1"><?php echo $result['gender'];?></td>
                                        </tr>
                                        <tr>
                                            <td ><b>Employee Email:</b></td>
                                            <td colspan="1"><?php echo $result['email'];?></td>
                                            <td ><b>Employee Contact:</b></td>
                                            <td colspan="1"><?php echo $result['contact_number'];?></td>
                                            <td ><b>Leave Id:</b></td>
                                            <td colspan="1"><?php echo $result['lid'];?></td>   
                                        </tr>
                                        <tr>
                                            <td ><b>Leave From:</b></td>
                                            <td colspan="1"><?php echo $result['start_date'];?></td>
                                            <td><b>Leave Upto:</b></td>
                                            <td colspan="1"><?php echo $result['end_date'];?></td>
                                            <td ><b>Documents:</b></td>
                                            <td >
                                            <form action="document.php?leave_id=<?php echo $result['lid']; ?>" method="POST">
							 			<input type="hidden" name="appid" value="<?php echo $result['lid']; ?>">
							 			<input type="submit" class="btn btn-sm" style="padding: 1px 20px;background-color:black;color:white;" name="view" value="Click here to view">
										<!-- <input type="submit" class="btn btn-sm btn-danger" name="decline" value="Decline"> -->
									</form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td ><b>Leave Applied:</b></td>
                                            <td><?php echo $result['applied_on'];?></td>
                                            <td ><b>Status:</b></td>
                                            <td><?php $stats=$result['leave_status'];
                                            if($stats=='Approved'){?>
                                                <span style="color: green">Approved</span>
                                                <?php } if($stats=='Declined')  { ?>
                                                <span style="color: red">Declined</span>
                                                <?php } if($stats=='Pending')  { ?>
                                                <span style="color: orange">Pending</span><?php } ?>
                                            </td>
                                            <td ><b>Leave Name:</b></td>
                                            <td colspan="1"><?php echo $result['leave_name'];?></td>
                                        </tr>
                                        <tr>
                                        <td ><b>Leave Combination:</b></td>
                                            <td><?php $com=$result['combinations'];
                                            $sql = "SELECT leave_name FROM leavetype WHERE leave_type_id='$com'";
                                            $result = mysqli_query($con, $sql);
                                            if($result)
                                            {
                                                $row = mysqli_fetch_array($result);  
                                                $count = mysqli_num_rows($result);
                                            }
                                                $l=$row["leave_name"]; 
                                                echo $l;?></td>
                                            
                                         </tr>

                                        <?php 
                                            if($stats=='Pending'){
                                        ?>
                                        <tr>
                                            <td colspan="12">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">SET ACTION</button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary"><a href="principal1.php" style="color:white"> DASHBOARD </a></button>
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">SET ACTION</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="POST" name="adminaction">
                                                                <div class="modal-body">
                                                                    <select class="custom-select" name="status" required="">
                                                                        <option value="">Choose...</option>
                                                                        <option value="Approved">Approve</option>
                                                                        <option value="Declined">Decline</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success" name="update">Apply</button>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                                            </form>
                                        <!-- </tr> -->
                                        <?php $cnt++;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jquery latest version -->
    <script src="./assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/metisMenu.min.js"></script>
    <script src="./assets/js/jquery.slimscroll.min.js"></script>
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="./assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="./assets/js/pie-chart.js"></script>
    
    <!-- others plugins -->
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/scripts.js"></script>
</body>
</html>
<?php } ?>