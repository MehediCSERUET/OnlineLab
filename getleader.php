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
<th>Roll</th>
<th>ProblemID</th>
<th>Verdict</th>
<th>TimeStamp</th>
</tr>";

try {
    $stmt = $db->prepare("SELECT * FROM `labdata` ORDER BY `Roll` ASC;");
    $result = $stmt->execute();
    while($row = $stmt->fetch()){
        echo "<tr>";
        echo "<td>".$row['Roll']."</td>";
        echo "<td>".$row['ProblemID']."</td>";
        echo "<td>".$row['Verdict']."</td>";
        echo "<td>".$row['Time']."</td>";
        echo "</tr>";
    }
    
    } catch (PDOException $e){
        echo "Couldn't run statement: " . $e->getMessage();
    }
?>
</body>
</html>