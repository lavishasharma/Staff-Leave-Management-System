<?php
	include("config.php");
	if(isset($_POST['redirect'])){
    header('Location: '.$_POST['con']);
    exit;
}
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="stylesheet" href="style1.css" />
    <title>dropdown Menu</title>
  </head>
  <body>
    <div class="menu-bar">
      <h1 class="logo">LEAVE<span>SYSTEM.</span></h1>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Login as<i class="fas fa-caret-down"></i></a>

            <div class="dropdown-menu">
                <ul>
                  <li><a href="login1.php">Principal</a></li>
                  <li><a href="login2.php">Admin</a></li>
                  <li><a href="login3.php">Hod</a></li>
                  <li><a href="login4.php">Employee</a></li>
                  
                </ul>
              </div>
        </li>
        
        <li><a href="#">Contact us</a></li>
      </ul>
    </div>

    <div class="hero">
      &nbsp;
    </div>
  </body>
</html>
