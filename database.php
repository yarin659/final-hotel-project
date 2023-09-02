<?php
/*
    functions section
*/
function createTable($db)
{
    //Create the users table
    $db->exec("CREATE TABLE IF NOT EXISTS reservations (
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    room TEXT NOT NULL,
    reserved_date DATE,
    user_message TEXT
    )");
}

function isFull($db, $room, $date)
{
    //build the query
    $sql = "SELECT * FROM reservations WHERE room = '$room' AND reserved_date = '$date'";

    //Execute a query to retrieve data
    $result = $db->query($sql);

    //Loop through the results and display count them
    //The data don't really matter, the count is
    $rooms_taken = 0;
    while ($row = $result->fetchArray())
    {
        $rooms_taken += 1;
    }

    return($rooms_taken >= 5);
}

function addRoom($db, $username, $email, $room, $date, $message)
{
    // Prepare a statement to insert data into the users table
    $stmt = $db->prepare("INSERT INTO reservations (username, email, room, reserved_date, user_message)
    VALUES (:username, :email, :room, :reserved_date, :user_message)");
  
    // Bind the data to the statement
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':room', $room);
    $stmt->bindValue(':reserved_date', $date);
    $stmt->bindValue(':user_message', $message, SQLITE3_TEXT);
    
    // Execute the statement to insert the data
    $stmt->execute();
}


//code section:

// Connect to the SQLite database
$db = new SQLite3('sqlite.db');

//getting the user input
$username = $_POST['name'];
$email = $_POST['email'];
$room = $_POST['room'];
$date = $_POST['date'];
$message = $_POST['message'];

//edit the date
$timestamp = strtotime($date); // convert date input to timestamp
$date = date('Y-m-d', $timestamp); // Get current date and time in the correct format

echo "Name:" . $username . "<br>";
echo "Email: " . $email . "<br>";
echo "Room_type: " . $room . "<br>";
echo "Date: " .$date . "<br>";
echo "Message: " . $message . "<br>";

//creating the table
createTable($db);

//checking that all the input is valid
if($username == NULL || $email == NULL || $room == NULL || $date == NULL || $message == NULL)
{
    echo "Invalid input";
}
//checking if the room reservation is full
else if(!isFull($db, $room, $date))  
{
    addRoom($db, $username, $email, $room, $date, $message);
    echo "Your reservation have been saved!";
}
else
{
    echo "Sorry, but all the rooms of the specified type have been taken.";
}

// Close the database connection
$db->close();

sleep(5);

echo "<br>In couple of seconds you will be back to the website.";
header('Refresh: 10; URL=http://127.0.0.1/hotel/home.html');
exit;
?>