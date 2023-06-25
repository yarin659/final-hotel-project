<?php
	$email = $_GET['email'] ?? '';

	// SQLite database filename
	$db_file = "example.db";
	$rooms = array("basic", "family", "suite");

	try {
		// Create a new PDO connection to the SQLite database
		$pdo = new PDO("sqlite:$db_file");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Prepare and execute the SQL statement
		$statement = $pdo->prepare("
			SELECT CUSTOMERS.name, ORDERS.from_date, ORDERS.to_date,ORDERS.actual_people, ORDERS_DETAILS.room_id, ROOMS.num_people
			FROM CUSTOMERS
			JOIN ORDERS ON CUSTOMERS.id = ORDERS.customer_id
			JOIN ORDERS_DETAILS ON ORDERS.id = ORDERS_DETAILS.order_id
			JOIN ROOMS ON ORDERS_DETAILS.room_id = ROOMS.id
			WHERE CUSTOMERS.mail = :email
		");
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
		$statement->execute();

		// Fetch the results as an associative array
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		// Process the results
		foreach ($results as $row) {
			echo "Name: " . $row['name'] . "<br>";
			echo "Room Number: " . $row['room_id'] . "<br>";
			echo "Room Type: " . $rooms[$row['num_people'] / 2 - 1] . "<br>";
			echo "People Amount: " . $row['actual_people'] . "<br>";
			echo "From Date: " . $row['from_date'] . "<br>";
			echo "To Date: " . $row['to_date'] . "<br>";
			
			echo "<br>";
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}


?>

<?php
	
?>