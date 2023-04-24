<?php
if(isset($_POST["ids"])){
    include_once("../conn.php");
    $json = $_POST["ids"];
    $ids = json_decode($json);

    
  $columns_name = array();
  $sql = "SELECT id,name from columns;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $columns_name["c".$row["id"]] = $row["name"];
    }
  }

  $subject_names = array();
  $sql = "SELECT id, name from subject;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $subject_names[$row["id"]] = $row["name"];
    }
  }

    $sql = "SELECT * from firm where firm.id in (";
    for($x = 0;$x < count($ids->{'ids'});$x++){
      $sql .= $ids->{'ids'}[$x];
      if($x != count($ids->{'ids'})-1){
          $sql .= ",";
      }
  }
  $sql.= ");";


$result = $conn->query($sql);
$csv_first_line = false;
$csv_first = "";
$csv = "";
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $x = 0;
    foreach ($row as $key => $value) {
        if(!$csv_first_line){
          if($x < 17){
            $csv_first .= $key . ";";
          } else{
            $csv_first .= $columns_name[$key] . ";";
          }
          
        }
        $x += 1;
        if($key == "subject_id"){
          $csv .= $subject_names[$value] . ";";
          continue;
        }
        $csv .= $value . ";";

        
    }
    $csv .= "\n";
    $csv_first_line = true;
  }
  // echo "<br>";
  // echo $csv;
}
$conn->close();

$csv = $csv_first . "\n" . $csv;

$file = "export.csv";
$txt = fopen($file, "w") or die("Unable to open file!");
fwrite($txt, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $csv));
fclose($txt);
header("Content-Type: text/plain; charset=ISO-8859-1");
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);

}



?>