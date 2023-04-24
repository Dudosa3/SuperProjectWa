<?php
$username = "lm";
$passwd = "";


$servername = "127.0.0.1";
$usernameDb = "root";
$password = "";
$dbname = "crm";
$conn = new mysqli($servername, $usernameDb, $password, $dbname);
 $conn->query("set names utf8");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  exit();
}
?>
