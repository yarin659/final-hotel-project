<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="hotelstyle.css">
    <link rel="stylesheet" media="screen and(max-width: 768px" href="mobile_hotel.css">

    <script src="https://kit.fontawesome.com/fbb2dc004c.js" crossorigin="anonymous"></script>
    <title>Contact</title>

    <style>

        p{
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .order {
          margin-bottom: 20px;
        }
        
        .order-label {
          font-weight: bold;
        }
      </style>
</head>
<body>

<?php
if (!isset($_GET["email"]))
        header ("Location: signin.html");


?>

    <nav id="navbar">
             <h1 class="Logo"><a href="home.html"></a>HBT </h1>
             <ul>
                <li> <a href="home.html">Home</a> </li>
                <li> <a href="About.html">About</a> </li>
                <li> <a  class="current" href="Contact.php">Contact</a> </li>
                <li> <a href="room.html">Rooms</a> </li>
             </ul>
    </nav>

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
			
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}


?>

<?php
	
?>
    <section id="contact" class="py3">
        <div class="containor"> 
            <h1><span class="lead-text">Your</span> Reservation</h1>
            <p>here are your future reservation:</p>

            <div class="order">
                <span class="order-label">Name:</span>
                <span id="name"><?php echo $row['name']; ?> </span>
              </div>
              
              <div class="order">
                <span class="order-label">Room Number:</span>
                <span id="room-number"><?php echo $row['room_id']; ?></span>
              </div>
              
              <div class="order">
                <span class="order-label">Room Type:</span>
                <span id="room-type"><?php echo $rooms[$row['num_people'] / 2 - 1] ?></span>
              </div>
              
              <div class="order">
                <span class="order-label">People Amount:</span>
                <span id="people-amount"><?php echo $row['actual_people']; ?></span>
              </div>
              
              <div class="order">
                <span class="order-label">From Date:</span>
                <span id="dates"><?php echo $row['from_date'] ?></span>
              </div>

              <div class="order">
                <span class="order-label">To Date:</span>
                <span id="dates"><?php echo $row['to_date'] ?></span>
              </div>

        </div>


    </section>

    

    <section id="contact" class="py3">
        <div class="container"> 
            <h1><span class="lead-text">Make a</span> Reservation</h1>
            <p>Fill out the form below to make a new reservation</p>
            <form action="database.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label><br>
                    <input type="text" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">People Amount</label><br>
                    <input type="text" id="people-amount" name="people-amount">
                </div>
    
                <div class="form-group">
                    <div class="custom-select" style="width:150px;"> 
                        <label for="room">Room type</label><br>
                        <select name="room_type" id="room_type">
                            <option value="family_room">Family Room</option>
                            <option value="basic_room">Basic Room</option>
                            <option value="suite_room">Suite Room</option>
                        </select>
                    </div>
    
                    <div class="form-group">
                        <label for="date">Date</label><br>
                        <input type="date" id="date" name="start_date">
                    </div>
    
                    <div class="form-group">
                        <label for="to_date">To Date</label><br>
                        <input type="date" id="to_date" name="end_date">

                    </div>

                    <button type="submit" class="btn-dark">Submit</button>
                </div>
    
                
               
            </form>
        </div>
    </section>
    




    <section id="features">
        <div class="box bg-dark">
            <i class="fa-solid fa-hotel fa-2x"></i>
            <h3>Location</h3>
            <p>Jerusalem</p>
        </div>
        <div class="box bg-dark">
            <i class="fa-solid fa-phone fa-2x"></i>
            <h3>Phone </h3>
            <p>050-2106216</p>
            

        </div>
        <div class="box bg-dark">
            <i class="fa-solid fa-envelope fa-2x"></i>
            <h3>Mail</h3>
            <p>yarin659@gmail.com</p>
        </div>

        <div class="box bg-dark">
            <i class="fa-brands fa-instagram fa-2x"></i>
            <h3>Instagram</h3>
            <p>Hotel_yarin</p>
        </div>
    </section>


    <script src="room_select.js"></script>

    <footer id="main-footer">
        <p> HBT &copy; 2022 All Rights Reserved To Yarin Cohen</p>
        
    </footer>
    
</body>
</html>