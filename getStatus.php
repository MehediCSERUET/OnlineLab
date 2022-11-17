<?php
    require_once('db.php');
    $stmt = $db->prepare("SELECT `Approved` FROM `users` WHERE `Role` LIKE 'student' GROUP BY `Approved`;");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    if(count($result) > 1){
        echo "Not Approved";
    } else {
        if($result[0]["Approved"] == "yes")
            echo "Approved";
        else
            echo "Not Approved";
    }

?>