<?php
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	{
    		header("location: principal1.php");
   		exit;
	}
	require_once "config.php";

	$username = $password = "";
	$username_err = $password_err = $login_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
    		if(empty(trim($_POST["username"])))
        		$username_err = "Please enter username.";
    		else
        		$username = trim($_POST["username"]);
    		if(empty(trim($_POST["password"])))
        		$password_err = "Please enter your password.";
    		else
        		$password = trim($_POST["password"]);
    
    		if(empty($username_err) && empty($password_err))
		{
        		$sql = "SELECT DECODE(password,'ABC') FROM special_role WHERE username='$username' and desig_id=1";
        		if($stmt = mysqli_prepare($con, $sql))
			{
            			//mysqli_stmt_bind_param($stmt, "s", $param_username);
            			//$param_username = $username;
            			if(mysqli_stmt_execute($stmt))
				{
                			mysqli_stmt_store_result($stmt);
                			if(mysqli_stmt_num_rows($stmt) == 1)
					{                    
                    				mysqli_stmt_bind_result($stmt, $decoded);
                    				if(mysqli_stmt_fetch($stmt))
						{
                        				if($password==$decoded)
							{
                            					session_start();
                            					$_SESSION["loggedin"] = true;
                            					$_SESSION["id"] = $id;
                            					$_SESSION["username"] = $username;
                            					header("location: principal1.php");
                        				} 
							else
                            					$login_err = "Invalid password.";
                        			}
                    			} 
					else
						$login_err = "Invalid username.";
                		}
				else
                			echo "Oops! Something went wrong. Please try again later.";
            			mysqli_stmt_close($stmt);
        		}
		}
    		mysqli_close($con);
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Principal Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="login.css" />
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
	<div class="login_form_container">
    	<div class="login_form">
			<br>
        	<h2> Principal Login</h2>
        	<br><center><p>Please fill in your credentials to login</p></center>
        	<?php 
        		if(!empty($login_err)){
            		echo '<div class="alert alert-danger">' . $login_err . '</div>';
        		}        
        	?>
       		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<br><br><div class="input_group">
            		<i class="fa fa-user"></i>
            		&nbsp;&nbsp;<input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            		<span class="invalid-feedback"><?php echo $username_err; ?></span>
            	</div>    
				<br><div class="input_group">
          			<i class="fa fa-unlock-alt"></i>
                	&nbsp;&nbsp;<input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                	<span class="invalid-feedback"><?php echo $password_err; ?></span>
            	</div>
            	<br><br><div class="button_group" id="login_button">
                	<center><input type="submit" class="btn btn-primary" value="Login"></center>
            	</div>
        	</form>
    	</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="login.js"></script>
</body>
</html>