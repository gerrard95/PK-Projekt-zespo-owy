<?php
// Enter your Host, username, password, database below.
// I left password empty because i do not set password on localhost.
$con = mysqli_connect("localhost","root","","register");
$conn = mysqli_connect("localhost","root","","baza_siatkarzy");

$langadb = "SET NAMES utf8";
mysqli_query($conn, $langadb);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>