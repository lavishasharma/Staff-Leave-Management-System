<?php
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	{
    		header("location: welcome.php");
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
        		$sql = "SELECT DECODE(password,'special') FROM special_role WHERE username='$username' and desig_id=3";
        		if($stmt = mysqli_prepare($link, $sql))
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
                            					header("location: welcome.php");
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
    		mysqli_close($link);
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOD Login</title>
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
    <!-- <div class="wrapper"> -->
	<div class="login_form_container">
      <div class="login_form">
<br> <br>
        <h2> HOD Login </h2>

        <!-- <br><p>Please fill in your credentials to login.</p> -->

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- <div class="form-group">
                <label>Username</label> -->
				<div class="input_group">
                <i class="fa fa-user"></i>
                <input type="text" name="username"  placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <!-- <div class="form-group">
                <label>Password</label> -->
				<div class="input_group">
                <i class="fa fa-unlock-alt"></i>
                <input type="password" name="password"  placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <!-- <div class="form-group"> -->
			<div class="button_group" id="login_button">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="login.js"></script>
</body>
</html>