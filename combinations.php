<?php
$emp_id=$_SESSION["eid"];
$comb=$_SESSION['comb'];
$p=0;
$start_date= date_create($_SESSION["cs"]);
        $end_date= date_create($_SESSION["ce"]);
        $diff=date_diff($start_date,$end_date);
        $interval = new DateInterval('P1D');
        $day=($diff->format('%d'));
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
            $nod_err="Combinations: Already applied on one of the dates";
	$cdays=$day;
switch ($comb) {
  case 2:
    $sql = "SELECT medical_leaves FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
		$left=$row["medical_leaves"];   
	
        if($day>$left)
        {
        $nod_err="Not enough leaves left";
        }
	$sql = "UPDATE employee SET medical_leaves=(SELECT medical_leaves FROM employee WHERE emp_id='$emp_id')-$day WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
    break;
  case 3:
   $day=($diff->format('%d'))-$cdays;
        $dff=date_diff(now(),$start_date);
        
        if(($diff->format('%d'))<7)
         $nod_err="Combination: 7 days prior notice needed";
        if($diff>60)
        {
        $nod_err="Combination: Only 60 days allowed";
        }
	
    break;
  case 4:
$leave_id=$_SESSION["leave_id"];
    $sql = "SELECT halfpay_leaves FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
		$left=$row["halfpay_leaves"];
    	$l=2*($left);
        if($day>$l)
        {
        $nod_err="Not enough leaves left";
        }
	if(empty($nod_err))
		{
	$sql = "UPDATE employee SET halfpay_leaves=(SELECT halfpay_leaves FROM employee WHERE emp_id='$emp_id')-$day WHERE emp_id='$emp_id'";
        $result = mysqli_query($con, $sql);
      }
    break;
  case 5:
	
    break;
case 6:
$sql = "SELECT years_of_servic FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{	
        if(($row["years_of_service"])<3)
        $nod_err="Special Study leave criteria not met";
	$dff=date_diff(now(),$start_date);
	if(($dff->format('%d'))<60)
         $nod_err="60 days prior notice needed";
        if($diff>365)
        {
        $nod_err="Only 1 year allowed at a time";
         } }
    break;
case 7:
 $sql = "SELECT years_of_service FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
	$nod_err ="";
	if(($row["years_of_service"])<2)
        $nod_err="Special Study leave criteria not met";
	$dff=date_diff(now(),$start_date);
	if(($dff->format('%d'))<30)
         $nod_err="30 days prior notice needed";
        if($diff>365)
        {
        $nod_err="Only 1 year allowed at a time";
        }
	
    break;
case 8:
    $sql = "SELECT gender FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
		$g=$row["gender"];
    if($g!="Female")
        $nod_err="Only Female Professors can apply for a leave";
   
//  echo "  <form action="" method="post"><label for="leave type">Reason: </label>
// 		<select name="Reason">
// 			<option value="maternity">Maternity</option>
// 			<option value="miscarriage">Miscarriage</option>
// 			<option value="adopt">Child Adoption</option>
// 		</select></form>";
$day=($diff->format('%d'))-$cdays;
        if($day>135 && $_POST["Reason"]=="Maternity")
        {
        $nod_err="Limit exceeded for the given reason";
        }
        if($day>135 && $_POST["Reason"]=="Child Adoption")
        {
        $nod_err="Limit exceeded for the given reason";
        }
        if($day>42 && $_POST["Reason"]=="Miscarriage")
        {
        $nod_err="Limit exceeded for the given reason";
        }
break;
case 9:
	if($day>21)
        {
        $nod_err="Only 21 days allowed";
        }
    break;
case 10:
    $leave_id=$_SESSION['leave_id'];
    $sql="DELETE FROM compensatory where DATEDIFF(expiration_date,NOW())<=0";
    $result = mysqli_query($con, $sql);
    $sql = "SELECT sum(no_of_leaves) as sum FROM compensatory WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	if($result)
    {
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
		$left=$row["sum"];
    break;
if($diff>$left )
        {
        $nod_err="Not enough leaves left";
        }
        if(empty($nod_err))
		{
            $day=($diff->format('%d'));
            $start_date= $_POST["start_date"];
            $end_date= $_POST["end_date"];
            $i=0;
            while($i<=$day)
            {
                $sql="SELECT  id, no_of_leaves from compensatory where emp_id='$emp_id'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result); 
                $IDD=$row["id"];
                if($row["no_of_leaves"]>1)
                {
                    $i=$i+$row["no_of_leaves"];
                    if($i>$day)
                    {
                        $del=$row["no_of_leaves"]-($i-$day);
                        $sql="UPDATE compensatory SET no_of_leaves=no_of_leaves-$del where id=$IDD";
                        $result = mysqli_query($con, $sql);
                    }
                    else
                    {
                        $i=$i+1;
                        $sql="DELETE FROM compensatory WHERE id=$IDD";
                        $result = mysqli_query($con, $sql);
                    }
                }
                else
                {
                    $sql="DELETE FROM compensatory where id=$IDD";
                    $result = mysqli_query($con, $sql);
                }
            }    }
case 11:
 $sql = "SELECT halfpay_leaves FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
		$left=$row["halfpay_leaves"];
	if($diff>$left)
        $nod_err="Limit reached";
        if($diff>90)
        {
        $nod_err="Only 90 days allowed";
        }
	 if(empty($nod_err))
		{ $sql = "UPDATE `employee` SET halfpay_leaves=(SELECT halfpay_leaves FROM employee WHERE emp_id='$emp_id')-$day WHERE emp_id='$emp_id'";
        $result = mysqli_query($con, $sql);}
    break;
case 12:
 $sql = "SELECT specialdisabiltiy_leaves FROM employee WHERE emp_id='$emp_id'";
	$result = mysqli_query($con, $sql);
	$count=0;
	if($result)
	{
		$row = mysqli_fetch_array($result);  
		$count = mysqli_num_rows($result);
	}
		$g=$row["specialdisabiltiy_leaves"];
        if($diff>$g)
        {
        $nod_err="LIMIT REACHED";
        }
        if(empty($nod_err))
		{
            $day=($diff->format('%d'));
            $sql = "UPDATE `employee` SET `specialdisability_leaves`=(SELECT specialdisability_leaves FROM employee WHERE emp_id='$emp_id')+$day WHERE emp_id='$emp_id'";
            $result = mysqli_query($con, $sql);
        }
        else
            echo $nod_err;
	
    break;
    }
?>