<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Display PDF</title>
    <style media="screen">
      embed{
        border: 2px solid black;
        margin-top: 30px;
      }
      .div1{
        margin-left: 170px;
      }
    </style>
  </head>
  <body>
    <div class="div1">
      <?php
      include 'config.php';
      // $lid=$_GET['leave_id'];
      session_start();
      // if(isset($_POST['appid']))
      // {
        $ld=$_POST['appid'];
        $sql="SELECT documents from leaves where leave_id='$ld'";
        $query=mysqli_query($con,$sql);
        while ($info=mysqli_fetch_array($query)) {
          ?>
        <embed type="application/pdf" src="pdf/<?php echo $info['documents'] ; ?>" width="900" height="500">
      <?php
        }
        //}
      ?>
    </div>
    <?php
    include'config.php';
    $lid=$_GET['leave_id'];
    $sql1="SELECT leave_id from leaves where leave_id='$lid'; ";
    $que = mysqli_query($con,$sql1);
    $cnt=1;
    while ($result = mysqli_fetch_assoc($que)) 
    {
      
?>
<tr>

  <td>
    <center>
    <form action=" details.php?leave_id=<?php echo $result['leave_id']; ?> " method="POST">
							 			<input type="hidden" name="appid" value="<?php echo $result['leave_id']; ?>">
							 			<input type="submit" class="btn btn-sm" style="padding: 1px 20px;background-color:black;color:white;" name="view" value="Back to view details page">
    </center>
    </td>

    </tr>
    <?php } ?>
                  </body>
</html>
