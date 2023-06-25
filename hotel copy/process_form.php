<?php
define("CUSTOMER", 0);
define("CLEANER", 1);
define("MANAGER", 2);

$email = $_POST['email'];
$password = $_POST['password'];
print_r($_POST);

// Perform authentication logic here...
// SQLite database filename
$db_file = "example.db";

// Create a PDO connection to the database
$pdo = new PDO("sqlite:$db_file");

// Prepare a SQL statement
$stmt = $pdo->prepare("SELECT password, level FROM CUSTOMERS WHERE mail = :email");

// Bind the email parameter
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();

// Fetch the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the number of rows
$numRows = 0;

// Print the results
foreach ($results as $row) 
{
	$numRows++;
    echo "Password: " . $row['password'] . "<br>";
	if ($row['password'] == $password)
	{
		echo "Equal";
		if($row['level'] == CUSTOMER)
		{
			header("Location: success.php?email=" . $email);
		}
		else if($row['level'] == CLEANER)
		{
		}
		else if($row['level'] == MANAGER)
		{
		}
		exit();
	}
	else
	{
		echo "Not equal";
		header("Location: sign.php?error=incorrect");
        exit(); // Make sure to exit after the redirection
	}
	
}
if ($numRows == 0)
{
	echo "Email not exist<br>";
	header("Location: sign.php?error=email_not_found");
    exit(); // Make sure to exit after the redirection
}
?>