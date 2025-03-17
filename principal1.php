<?php
    include('head.php'); 
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
    		header("location: login1.php");
    		exit;
	}
?>
<html>
<body>
	<nav class="navbar navbar-toggleable-sm navbar-inverse bg-primary p-0">
		<div class="container">
			<button class="navbar-toggler toggler-right" data-target="#mynavbar" data-toggle="collapse">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a href="#" class="navbar-brand mr-3"></a>
			<div class="collapse navbar-collapse" id="mynavbar">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown mr-3">
						<li class="nav-item">
							<a href="logout.php" class="nav-link"><h5><i class="fa fa-power-off"></i> Logout</h5></a>
						</li>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!--This Is Header-->
	<header id="main-header" class="bg-danger py-2 text-white">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1><i class="fa fa-user"></i> Principal Dashboard</h1>
				</div>
			</div>
		</div>
	</header>
	<!--This is section-->
	<section id="sections" class="py-4 mb-4 bg-faded">
		<div class="container">
			<div class="row">
				<div class="col-md"></div>
				<div class="col-md-2">
					<a href="#" class="btn btn-warning btn-block" style="border-radius:0%;" data-toggle="modal" data-target="#addPostModal"><i class="fa fa-spinner"></i> Pending </a>
				</div>
				<div class="col-md-2">
					<a href="#" class="btn btn-success btn-block" style="border-radius:0%;" data-toggle="modal" data-target="#addCateModal"><i class="fa fa-check"></i> Approved </a>
				</div>
				<div class="col-md-2">
					<a href="#" class="btn btn-danger btn-block" style="border-radius:0%;" data-toggle="modal" data-target="#addUsertModal"><i class="fa fa-close"></i> Declined </a>
				</div>
				<div class="col-md-2">
					<a href="#" class="btn btn-info btn-block" style="border-radius:0%;" data-toggle="modal" data-target="#viewEmpModal"><i class="fa fa-eye"></i> View Employees </a>
				</div>
				<div class="col-md"></div>
			</div>
		</div>
	</section>
	<!----Section2 for showing Post Model ---->
	<section id="post">
		<div class="container">
			<div class="row">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<th style="text-align:center">SL NO.</th>
						<th style="text-align:center">LEAVE ID</th>
						<th style="text-align:center">EMPLOYEE ID</th>
						<th style="text-align:center">LEAVE TYPE</th>
						<th style="text-align:center">START DATE</th>
						<th style="text-align:center">END DATE</th>
						<th style="text-align:center">APPLIED ON</th>
						<th style="text-align:center">STATUS</th>
					</thead>
					<tbody>
						<?php 
							$sql = "select lt.leave_id,lt.emp_id,lt.leave_status ,ll.leave_name,lt.start_date,lt.end_date,lt.applied_on from leaves lt,leavetype ll where lt.leave_type_id=ll.leave_type_id";
							$que = mysqli_query($con,$sql);
							$cnt = 1;
							while ($result = mysqli_fetch_assoc($que)) {			
						?>	
						<tr>
							<td style="text-align:center"><?php echo $cnt;?></td>
							<td style="text-align:center"><?php echo $result['leave_id']; ?></td>
                            <td style="text-align:center"><?php echo $result['emp_id']; ?></td>
							<td style="text-align:center"><?php echo $result['leave_name']; ?></td>
							<td style="text-align:center"><?php echo $result['start_date']; ?></td>
							<td style="text-align:center"><?php echo $result['end_date']; ?></td>
							<td style="text-align:center"><?php echo $result['applied_on']; ?></td>
							<td style="text-align:center">
							 	<?php 
							 		if ($result['leave_status'] == 'Pending') {
										echo "<span class='badge badge-warning'>Pending</span>";
							 		}
									else if ($result['leave_status'] == 'Approved') {
										echo "<span class='badge badge-success'>Approved</span>";
							 		}
							 		else{
										echo "<span class='badge badge-danger'>Declined</span>";
							 		}
							 		$cnt++;	}
							 	?>
							</td>
						</tr>	
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- Pending Modal -->
	<div class="modal fade" id="addPostModal">
		<div class="modal-dialog modal-lg" style="max-width:80%;" role="document">
			<div class="modal-content">
				<div class="modal-header bg-warning text-white">
					<div class="modal-title">
						<h5>Pending Leaves</h5>
					</div>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<th style="text-align:center">SL NO.</th>
							<th style="text-align:center">LEAVE ID</th>
                        	<th style="text-align:center">EMPLOYEE ID</th>
							<th style="text-align:center">LEAVE TYPE</th>
							<th style="text-align:center">START DATE</th>
							<th style="text-align:center">END DATE</th>
							<th style="text-align:center">APPLIED ON</th>
							<th style="text-align:center">STATUS</th>
							<th style="text-align:center">ACTION</th>
						</thead>
						<tbody>
							<?php 
								$sql = "select lt.leave_id,lt.emp_id,lt.leave_status ,ll.leave_name,lt.start_date,lt.end_date,lt.applied_on from leaves lt,leavetype ll where lt.leave_type_id=ll.leave_type_id and leave_status='Pending';";
								$que = mysqli_query($con,$sql);
								$cnt = 1;
								while ($result = mysqli_fetch_assoc($que)) {
								?>
							<tr>
								<td style="text-align:center"><?php echo $cnt;?></td>
								<td style="text-align:center"><?php echo $result['leave_id']; ?></td>
                                <td style="text-align:center"><?php echo $result['emp_id']; ?></td>
							 	<td style="text-align:center"><?php echo $result['leave_name']; ?></td>
							 	<td style="text-align:center"><?php echo $result['start_date']; ?></td>
							 	<td style="text-align:center"><?php echo $result['end_date']; ?></td>
							 	<td style="text-align:center"><?php echo $result['applied_on']; ?></td>
							 	<td style="text-align:center">
							 		<?php 
							 		if ($result['leave_status'] == 'Pending') {
							 			echo "Pending";
							 		?>
							 	</td>
							 	<td style="text-align:center">
									<form action="details.php?leave_id=<?php echo $result['leave_id']; ?>" method="POST">
							 			<input type="hidden" name="appid" value="<?php echo $result['emp_id']; ?>">
							 			<input type="submit" class="btn btn-sm btn-primary" name="view" value="View Details">
										<!-- <input type="submit" class="btn btn-sm btn-danger" name="decline" value="Decline"> -->
									</form>
							 	</td>
							 	<?php
							 		}
							 		// else{
							 		// 	echo "Approved";
							 		// }
							 		$cnt++;	}
							 	?>	
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--Approved Modal-->
	<div class="modal fade" id="addCateModal">
		<div class="modal-dialog modal-lg" style="max-width:80%;" role="document">
			<div class="modal-content">
				<div class="modal-header bg-success text-white">
					<div class="modal-title">
						<h5>Approved Leaves</h5>
					</div>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<th style="text-align:center">SL NO.</th>
							<th style="text-align:center">LEAVE ID</th>
                            <th style="text-align:center">EMPLOYEE ID</th>
							<th style="text-align:center">LEAVE TYPE</th>
							<th style="text-align:center">START DATE</th>
							<th style="text-align:center">END DATE</th>
							<th style="text-align:center">APPLIED ON</th>
							<th style="text-align:center">STATUS</th>
						</thead>
						<tbody>
							<?php 
								$sql = "select lt.leave_id,lt.emp_id,lt.leave_status ,ll.leave_name,lt.start_date,lt.end_date,lt.applied_on from leaves lt,leavetype ll where lt.leave_type_id=ll.leave_type_id and leave_status='Approved';";
								$que = mysqli_query($con,$sql);
								$cnt = 1;
								while ($result = mysqli_fetch_assoc($que)) {
							?>
							<tr>
								<td style="text-align:center"><?php echo $cnt;?></td>
								<td style="text-align:center"><?php echo $result['leave_id']; ?></td>
                                <td style="text-align:center"><?php echo $result['emp_id']; ?></td>
							 	<td style="text-align:center"><?php echo $result['leave_name']; ?></td>
							 	<td style="text-align:center"><?php echo $result['start_date']; ?></td>
							 	<td style="text-align:center"><?php echo $result['end_date']; ?></td>
							 	<td style="text-align:center"><?php echo $result['applied_on']; ?></td>
							 	<td style="text-align:center">
							 		<?php 
							 			if ($result['leave_status'] == 'Pending') {
											echo "<span class='badge badge-warning'>Pending</span>";
							 			}
							 			else{
											echo "<span class='badge badge-success'>Approved</span>";
							 			}
							 			$cnt++;	}
							 		 ?>
							 	</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--Declined Modal -->
	<div class="modal fade" id="addUsertModal">
		<div class="modal-dialog modal-lg" style="max-width:80%;" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<div class="modal-title">
						<h5>Declined Leaves</h5>
					</div>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<th style="text-align:center">SL NO.</th>
						<th style="text-align:center">LEAVE ID</th>
						<th style="text-align:center">EMPLOYEE ID</th>
						<th style="text-align:center">LEAVE TYPE</th>
						<th style="text-align:center">START DATE</th>
						<th style="text-align:center">END DATE</th>
						<th style="text-align:center">APPLIED ON</th>
						<th style="text-align:center">STATUS</th>
					</thead>
					<tbody>
						<?php 
							$sql = "select lt.leave_id,lt.emp_id,lt.leave_status ,ll.leave_name,lt.start_date,lt.end_date,lt.applied_on from leaves lt,leavetype ll where lt.leave_type_id=ll.leave_type_id and leave_status='Declined';";
							$que = mysqli_query($con,$sql);
							$cnt = 1;
							while ($result = mysqli_fetch_assoc($que)) {
						?>	
						<tr>
							<td style="text-align:center"><?php echo $cnt;?></td>
							<td style="text-align:center"><?php echo $result['leave_id']; ?></td>
							<td style="text-align:center"><?php echo $result['emp_id']; ?></td>
							<td style="text-align:center"><?php echo $result['leave_name']; ?></td>
							<td style="text-align:center"><?php echo $result['start_date']; ?></td>
							<td style="text-align:center"><?php echo $result['end_date']; ?></td>
							<td style="text-align:center"><?php echo $result['applied_on']; ?></td>
							<td style="text-align:center">
							 	<?php 
							 		if ($result['leave_status'] == 'Declined') {
										echo "<span class='badge badge-danger'>Declined</span>";
							 		}
							 		// else{
									// 	echo "<span class='badge badge-success'>Approved</span>";
							 		// }
							 		$cnt++;	}
							 	?>
							</td>
						</tr>
					</tbody>
				</table></div>
			</div>
		</div>
	</div>
	<!-- View Employee Modal -->
	<div class="modal fade" id="viewEmpModal">
		<div class="modal-dialog modal-lg" style="max-width:80%;" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<div class="modal-title">
						<h5>List of Employees</h5>
					</div>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<th style="text-align:center">SL NO.</th>
                            <th style="text-align:center">EMPLOYEE ID</th>
							<th style="text-align:center">NAME</th>
							<th style="text-align:center">DEPARTMENT</th>
							<th style="text-align:center">EMAIL ID</th>
							
						</thead>
						<tbody>
							<?php 
								$sql = "SELECT * FROM employee";
								$que = mysqli_query($con,$sql);
								$cnt = 1;
								while ($result = mysqli_fetch_assoc($que)) {
							?>	
							<tr>
								<td style="text-align:center"><?php echo $cnt;?></td>
								<td style="text-align:center"><?php echo $result['emp_id']; ?></td>
							 	<td style="text-align:center"><?php echo $result['emp_name']; ?></td>
							 	<td style="text-align:center"><?php echo $result['department']; ?></td>
							 	<td style="text-align:center"><?php echo $result['email']; ?></td>
								
							</tr>
						</tbody>
						<?php $cnt++; }?>
					</table>
				</div>
			</div>
		</div>
	</div>
  	<script src="js/jquery.min.js"></script>
  	<script src="js/tether.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
  	<script>
	CKEDITOR.replace('editor1');
  	</script>
</body>
</html>