<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
  padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php

require_once('db.php');

echo "<table>
<tr>
<th>Name</th>
<th>Roll</th>
<th>Email</th>
<th>Approved</th>
</tr>";

try {
    $stmt = $db->prepare("SELECT * FROM `users`;");
    $result = $stmt->execute();
    while($row = $stmt->fetch()){
        echo "<tr>";
        echo "<td>".$row['Name']."</td>";
        echo "<td>".$row['Roll']."</td>";
        echo "<td>".$row['Email']."</td>";
        echo "<td>".$row['Approved']."</td>";
        echo "</tr>";
    }
    
    } catch (PDOException $e){
        echo "Couldn't run statement: " . $e->getMessage();
    }
?>
</body>
</html>