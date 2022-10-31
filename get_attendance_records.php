<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');

$data = array();

$query = "SELECT * FROM attendance_records ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start"],
  'end'   => $row["end"]
 );
}

echo json_encode($data);

?>
