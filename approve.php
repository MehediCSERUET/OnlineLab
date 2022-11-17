<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php

require_once('db.php');

$status = $_GET['q'];

try {
    if($status == 'Not Approved'){
        $stmt = $db->prepare("UPDATE `users` SET `Approved` = 'yes' WHERE `users`.`Role` = 'student';");
        $result = $stmt->execute();
        if($result == true){
            echo "Approved";
        } else {
            echo "Not Approved";
        }
    } else {
        $stmt = $db->prepare("UPDATE `users` SET `Approved` = 'no' WHERE `users`.`Role` = 'student';");
        $result = $stmt->execute();
        if($result == true){
            echo "Not Approved";
        } else {
            echo "Approved";
        }
    }
    
    } catch (PDOException $e){
        echo "Couldn't run statement: " . $e->getMessage();
    }
?>
</body>
</html>