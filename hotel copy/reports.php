<?php
	// Perform authentication logic here...
	// SQLite database filename
	$db_file = "example.db";

	// Create a PDO connection to the database
	$pdo = new PDO("sqlite:$db_file");

	// Prepare a SQL statement
	$stmt = $pdo->prepare("SELECT ORDERS.to_date, ORDERS_DETAILS.room_id
						   FROM ORDERS
						   JOIN ORDERS_DETAILS ON ORDERS.id = ORDERS_DETAILS.order_id");


	// Execute the statement
	$stmt->execute();

	// Fetch the results
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	// Get the current date
	$currentDate = new DateTime();

	// Modify the current date to represent yesterday
	$currentDate->modify('-1 day');
	
	echo "Extended clean: " . "<br>";
	foreach ($results as $row) 
	{
		// Convert the date string to a DateTime object
		$date = DateTime::createFromFormat('d/m/Y', $row["to_date"]);

		// Compare the dates
		if ($date->format('Y-m-d') === $currentDate->format('Y-m-d')) {
			echo $row["room_id"] . "<br>";
		}
	}
	
	
?>

<?php
	// Perform authentication logic here...
	// SQLite database filename
	$db_file = "example.db";

	// Create a PDO connection to the database
	$pdo = new PDO("sqlite:$db_file");

	// Prepare a SQL statement
	$stmt = $pdo->prepare("SELECT ORDERS.to_date, ORDERS.from_date, ORDERS_DETAILS.room_id
						   FROM ORDERS
						   JOIN ORDERS_DETAILS ON ORDERS.id = ORDERS_DETAILS.order_id");


	// Execute the statement
	$stmt->execute();

	// Fetch the results
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	// Get today's date
	$today = new DateTime();
	
	echo "Regular Clean: " . "<br>";
	foreach ($results as $row) 
	{
		$startDateString = $row["from_date"]; // Example start date string
		$endDateString = $row["to_date"];   // Example end date string

		

		// Convert the start and end date strings to DateTime objects
		$start = DateTime::createFromFormat('d/m/Y', $startDateString);
		$end = DateTime::createFromFormat('d/m/Y', $endDateString);

		// Check if today's date is within the range
		if ($today >= $start && $today <= $end) {
			echo $row["room_id"] . "<br>";
		}
	}
?>

<?php
	// Perform authentication logic here...
	// SQLite database filename
	$db_file = "example.db";

	// Create a PDO connection to the database
	$pdo = new PDO("sqlite:$db_file");

	// Prepare a SQL statement
	$stmt = $pdo->prepare("SELECT room_id, COUNT(room_id) AS frequency FROM ORDERS_DETAILS GROUP BY room_id ORDER BY frequency DESC LIMIT 1");


	// Execute the statement
	$stmt->execute();

	// Fetch the results
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo "Most ordered room: " . $results[0]["room_id"] . ": " . $results[0]["frequency"] . "<br>";
?>

<?php
	// Assuming you have already connected to the SQLite database
	$db_file = "example.db";

	// Create a PDO connection to the database
	$pdo = new PDO("sqlite:$db_file");

	// Get the current year
	$currentYear = date('Y');
	echo $currentYear . "<br>";
	// Prepare a SQL statement to retrieve orders for the current year
	$stmt = $pdo->prepare("SELECT from_date, to_date FROM ORDERS");

	// Bind the year parameter
	//$stmt->bindParam(':year', $currentYear);

	// Execute the statement
	$stmt->execute();

	// Fetch the results
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($results as $row) 
	{
		echo $row["from_date"] . "-" . $row["to_date"] . "<br>"; 
		
	}
	// Initialize an array to store the monthly order counts
	$monthlyOrderCounts = array(
		'January' => 0,
		'February' => 0,
		'March' => 0,
		'April' => 0,
		'May' => 0,
		'June' => 0,
		'July' => 0,
		'August' => 0,
		'September' => 0,
		'October' => 0,
		'November' => 0,
		'December' => 0
	);

	// Loop through the results and count orders for each month
	foreach ($results as $row) {
		$fromDate = DateTime::createFromFormat('d/m/Y', $row['from_date']);
		$toDate = DateTime::createFromFormat('d/m/Y', $row['to_date']);
		
		$yearNumber = intval($currentYear);
		$fromNumber = intval($fromDate->format('Y'));
		$toNumber = intval($toDate->format('Y'));
		if($fromNumber <= $yearNumber && $yearNumber <= $toNumber)
			{
			$startMonth = $fromDate->format('F');
			$endMonth = $toDate->format('F');

			// Increment the count for each month between the start and end dates (inclusive)
			while ($fromDate <= $toDate) {
				$currentMonth = $fromDate->format('F');
				if($fromDate->format('Y') == $currentYear)
					$monthlyOrderCounts[$currentMonth]++;
				$fromDate->modify('+1 month');
			}
		}
	}

	// Output the monthly order counts
	foreach ($monthlyOrderCounts as $month => $count) {
		echo "$month: $count orders<br>";
	}

	// Close the database connection
	$pdo = null;
?>

