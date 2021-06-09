<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO users (ID, Name, Email, Balance)
VALUES ('001', 'Beth', 'beth@gmail.com', '450000'),
       ('002', 'Stanley', 'stanley@gmail.com', '30000'),
       ('003', 'Rachel', 'rachel@gmail.com', '74000'),
       ('004', 'Sophie', 'sophie@gmail.com', '50000'),
       ('005', 'Jack', 'jack@gmail.com', '100000'),
       ('006', 'Will', 'will@gmail.com', '99000'),
       ('007', 'Joanna', 'joanna@gmail.com', '147600'),
       ('008', 'David', 'david@gmail.com', '33500'),
       ('009', 'Chan', 'chan@gmail.com', '829000'),
       ('010', 'Rebecca', 'rebecca@gmail.com', '2579500')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>