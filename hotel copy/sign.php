<!DOCTYPE html>
<html>
<head>
  <title>Sign In</title>
</head>
<body>

	<form action="process_form.php" method="post">
	  <label for="email">Email:</label>
	  <input type="text" id="email" name="email"><br>
	  
	  <label for="password">Password:</label>
	  <input type="password" id="password" name="password"><br>
	  
	  <input type="submit" value="Submit">
	</form>
	<?php
		// Retrieve the error parameter
		$error = $_GET['error'] ?? '';

		// Display the error message based on the parameter
		if ($error === 'incorrect') 
		{
		  echo '<p>Error: Incorrect password.</p>';
		} 
		elseif ($error === 'email_not_found')
		{
		  echo '<p>Error: Email not found.</p>';
		}
	  ?>
  </body>
</html>