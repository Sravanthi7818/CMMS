<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
	  <div class="radio-group">
            <input type="radio" id="admin" class="radio-input" name="radio" value="admin" required>
            <label for="admin" class="radio-label">Admin</label>

            <input type="radio" id="user" class="radio-input" name="radio" value="user" required>
            <label for="user" class="radio-label">Worker</label>

            <input type="radio" id="employee" class="radio-input" name="radio" value="employee" required>
            <label for="employee" class="radio-label">Employee</label>
        </div>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  
  </form>
</body>
</html>