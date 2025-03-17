<?php
	include("config.php");
	session_start();
	
	$leave_id = $nod = $start_date = $end_date = "";
	$nod_err = "";
	$emp_id=$_SESSION["eid"];
    $leave_id=$_SESSION['leave_id'];
    $sql = "SELECT casual_leaves FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result); 
	$count=0;
	$left=$row["casual_leaves"];
	// if($left<4)
	// 	$days=$left;
	// else
	// 	$days=$left;
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
         #checking if laready applied
    $start_date= date_create($_POST["start_date"]);
    $end_date= date_create($_POST["end_date"]);
    $diff=date_diff($start_date,$end_date);
    $interval = new DateInterval('P1D');
$count=0;
$p=0;
$date_range = new DatePeriod($start_date, $interval, $end_date);
foreach ($date_range as $date) {
    $date=date_format($date,"Y/m/d");
    $sql="SELECT COUNT(*) AS C FROM leaves WHERE start_date<='$date' AND '$date'<=end_date AND emp_id='$emp_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result); 
    $count=$count+$row['C'];     
    $p = $p+$row['C'];
    
}
if($p>0)
    $nod_err="Already applied on one of the dates";
if($result)
{
    $row = mysqli_fetch_array($result);  
    $count = mysqli_num_rows($result);
}
$p=0;
        if(($diff->format('%d'))<=7)
        {
            $count=0;
            $p=0;
            $date_range = new DatePeriod($start_date, $interval, $end_date);
            foreach ($date_range as $date) {
                $date=date_format($date,"Y/m/d");
               $sql="SELECT COUNT(*) AS C FROM holiday_list WHERE start_datetime<='$date' AND '$date'<=end_datetime AND title<>'Puja Vaction'";
               $result = mysqli_query($con, $sql);
               $row = mysqli_fetch_array($result); 
               $count=$count+$row['C'];     
               $sql="SELECT COUNT(*) AS C FROM holiday_list WHERE start_datetime<='$date' AND '$date'<=end_datetime AND title='Puja Vacation'";
               $result = mysqli_query($con, $sql);
               $row = mysqli_fetch_array($result);
               $p = $p+$row['C'];
               
            }
               if($p>0)
               {
                $nod_err="Puja Holidays cannot be combined with any leaves";
               }
           $day=($diff->format('%d'))-$count;
            if($left<4 && $day>$left && empty($nod_err))
                $nod_err="Not enough casual leaves left.";
            if($left>=4 && $day>4 && empty($nod_err))
                $nod_err="Only 4 casual leaves can be taken at a time.";
            
        }
        else
            $nod_err="Only 7 days allowed.";
        $start_date= $_POST["start_date"];
        $end_date= $_POST["end_date"];
        if(empty($nod_err))
		{$sql = "INSERT INTO leaves (leave_id, emp_id, leave_type_id, start_date, end_date, leave_status) VALUES ('$leave_id', '$emp_id', '1
        ', '$start_date', '$end_date','Approved')";
		$result = mysqli_query($con, $sql);
		$sql = "UPDATE employee SET leaves_applied=leaves_applied+1 WHERE emp_id='$emp_id'";
        $result = mysqli_query($con, $sql);
        $sql = "UPDATE employee SET casual_leaves=casual_leaves-$day WHERE emp_id='$emp_id'";
        $result = mysqli_query($con, $sql);
        if($result)
{
    ?>
    <script>
        alert ('Submitted sucessfull');
        </script>
        <?php
}else{
    die ("Something went wrong");
}
       
    }
        else
        echo"<script> alert('$nod_err');</script>";
	}
	mysqli_close($con);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,
      initial-scale=1.0"/>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <h1 class="form-title">Apply for Casual leave</h1>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  action="casual_leave.php" method="post" enctype="multipart/form-data">
        <div class="main-user-info">
          <div class="user-input-box">
          <label>Total Leave Left:</label> <?php echo "<p align='right'> <font color=white size='4pt'>$left</font> </p>" ?>
          </div>
          <div class="user-input-box">
            <label>Start_Date:</label>
            <input type="date" name="start_date" >
          </div>

          
          <div class="user-input-box">
            <label>LEAVE_ID:</label> <br> <?php echo "<p align='left'> <font color=white size='4pt'>$leave_id</font> </p>" ?>
          </div>
          <div class="user-input-box">
            <label>End_Date:</label>
                <input type="date" name="end_date" >
          </div>
          <div class="user-input-box">
            <label>EMP_ID: </label> <?php echo "<p align='right'> <font color=white size='4pt'>$emp_id</font> </p>" ?>  
          </div>
          
          
          
        <center>
        <div class="form-submit-btn">
          <input id="submit" type="submit" name="submit" class="btn btn-primary" value="submit">
        </div>
</center>
      </form>
    </div>
  </body>
</html> 
 
