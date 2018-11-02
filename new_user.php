<!DOCTYPE html>
<html>
<head>
    <title>Add user</title>
    <meta charset="utf-8">
</head>

<body>
<?php
// Create connection
$conn = new mysqli("localhost", "roberto", "Amsesr.2108", "alumnos");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pswd = password_hash("amsesr1977", PASSWORD_DEFAULT);
$sql = "INSERT INTO users (user_id, username, password) VALUES (1, 'rsesma', '".$pswd."')";

if ($conn->query($sql)) {
  echo "Query executed.";
} else{
  echo "Query error.";
}
?>

</body>
</html>
