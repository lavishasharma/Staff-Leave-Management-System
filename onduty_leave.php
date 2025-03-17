<?php
	include("config.php");
	session_start();
	$leave_id = $nod = $start_date = $end_date = "";
	$nod_err = $start_err = $end_err = "";
	$emp_id=$_SESSION["eid"];
    $leave_id=$_SESSION["leave_id"];
    	if($_SERVER["REQUEST_METHOD"] == "POST")
	{	
        if(($_POST["comb"])==0)
    $id="5";
    else
    $id="5, ".$_POST["comb"];
        $_SESSION["comb"]=$_POST["comb"];
        $_SESSION["cs"]=$_POST["cst"];
        $_SESSION["ce"]=$_POST["cen"];
    include("combinations.php");
    $cdays=0;
        $start_date= date_create($_POST["start_date"]);
        $end_date= date_create($_POST["end_date"]);
        $diff=date_diff($start_date,$end_date);
        $interval = new DateInterval('P1D');
        $day=($diff->format('%d'));
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
        if(empty($nod_err))
		{
            $start_date= $_POST["start_date"];
            $end_date= $_POST["end_date"];
            $pdf=$_FILES['pdf']['name'];
            $pdf_type=$_FILES['pdf']['type'];
            $pdf_size=$_FILES['pdf']['size'];
            $pdf_tem_loc=$_FILES['pdf']['tmp_name'];
            $pdf_store="pdf/".$pdf;
  
            move_uploaded_file($pdf_tem_loc,$pdf_store);
            
        $sql = "INSERT INTO leaves (leave_id, emp_id, leave_type_id, start_date, end_date, leave_status,documents) VALUES ('$leave_id', '$emp_id', '$id', '$start_date', '$end_date','$pdf')";
		$result = mysqli_query($con, $sql);
		$sql = "UPDATE employee SET leaves_applied=(SELECT leaves_applied FROM employee WHERE emp_id='$emp_id')+1 WHERE emp_id='$emp_id'";
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
    #combinations

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
      <h1 class="form-title">Apply for On duty leave</h1>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  action="onduty_leave.php" method="post" enctype="multipart/form-data">
        <div class="main-user-info">
          
          

          <div class="user-input-box">
            <label>LEAVE_ID:</label> 
            <?php echo "<p align='center'> <font color=white size='4pt'>$leave_id</font> </p>" ?>
          </div>
          
          <div class="user-input-box">
            <label>Start_Date:</label>
            <input type="date" name="start_date" >
          </div>
          <div class="user-input-box">
            <label>EMP_ID: </label> <?php echo "<p align='right'> <font color=white size='4pt'>$emp_id</font> </p>" ?>  
          </div>
          <div class="user-input-box">
            <label>End_Date:</label>
                <input type="date" name="end_date" >
          </div>
         
          
          <div class="user-input-box">
            <label>Choose Your PDF File</label>
             <input id="pdf" type="file" name="pdf" value="" required>
          </div>
          <div class="user-input-box">
            <label>Select leave type: </label>
		<select name="comb">
    <option value="0">NA</option>
			<option value="2">MEDICAL LEAVE</option>
			<option value="4">COMMUTED LEAVE</option>
			<option value="3">EARNED LEAVE</option>
			<option value="6">STUDY LEAVE</option>
			<option value="7">SPECIAL STUDY ABSENCE</option>
			<option value="8">MATERNITY LEAVE</option>
			<option value="9">QUARANTINE LEAVE</option>
            <option value="10">COMPENSATORY LEAVE</option>
            <option value="11">LEAVE NOT DUE</option>
			<option value="12">SPECIAL DISABILITY LEAVE</option>
		</select>
          </div>

          <div class="user-input-box">
            <label>Combination leave Start_Date:</label>
                <input type="date" name="cst">
          </div>

          <div class="user-input-box">
            <label>Combination leave End_Date:</label>
                <input type="date" name="cen">
          </div>

          
        </div>
        
        <div class="form-submit-btn">
          <input id="submit" type="submit" name="submit" class="btn btn-primary" value="submit">
        </div>
      </form>
    </div>
  </body>
</html> 


