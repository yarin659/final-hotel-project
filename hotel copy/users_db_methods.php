<?php

/*
usefull functions to acsess the database 
*/
function getAllUsers($db)
{
    $users = [];
    
    //build the query
    $sql = "SELECT username FROM users";
    //execute the query
    $result = $db->query($sql);
    
    //adding the users to the arrey
    while ($row = $result->fetchArray())
    {
        $users += $row['username'];
    }

    return $users;
}


function doesPasswardMatch($db, $username, $password)
{
    //build the query
    $sql = "SELECT * FROM users WHERE username = '" + $username + "';";
    //execute the query
    $result = $db->query($sql);
    $row = $result->fetchArray(); //get the inly line
    
    return($row['password'] == $password);
}


function addUser($db, $username, $password)
{
    $stmt = $db->prepare("INSERT INTO users (username, password)
    VALUES (:username, :password)");
  
    // Bind the data to the statement
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    
    // Execute the statement to insert the data
    $stmt->execute();    
}


function signup($db, $username, $password)
{
    if(in_array($username, getAllUsers($db))) //if the username alteady exist we throw an exception
    {
        throw new Exception('Can\'t commit signup. User is already exist.');
    }

    addUser($db, $username, $password); //else, we add a new user
}

function login($db, $username, $password)
{
    if(in_array(!$username, getAllUsers($db))) //if the username alteady exist we throw an exception
    {
        throw new Exception('Can\'t commit login. User don\'t exist.');
    }
    
    if(!doesPasswardMatch($db, $username, $password)) //password don't 
    {
        throw new Exception('Can\'t commit login. Pawwsord don\'t match.');
    }
}
?>
