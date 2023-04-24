<?php
include_once("../conn.php");

if(isset($_GET["firm-name"])){
    $name = $_GET["firm-name"];
    $sql = "SELECT name FROM firm where name = '".$name."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "1";
} else {
  echo "0";
}
}
?>