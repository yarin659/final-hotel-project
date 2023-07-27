<?php
include 'users_db_methods';

//code section:

// Connect to the SQLite database
$db = new SQLite3('sqlite.db');

//getting the user input
$username = $_POST['name'];
$password = $_POST['password'];

try
{
   signup($db, $username, $password);
}
catch (Exception $e)
{
    echo $e->getMessage(), "\n";
}
finally
{
    // Close the database connection
    $db->close();
}
?>
