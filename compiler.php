<?php
session_start();
require_once("curl_helper.php");
require_once("db.php");

if(!isset($_SESSION['name']) || !isset($_SESSION['roll']) || !isset($_SESSION['email'])){
    header("Location: index.php", true, 301);
    exit();
} else {

    $stmt = $db->prepare("SELECT `Approved` FROM `users` WHERE `Email` = ?;");
    $stmt->execute(array($_SESSION['email']));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if($result[0]['Approved'] == "no"){
        echo '<script>
        alert("Wait for your account to be approved");
        </script>';
        header("Location: index.php", true, 301);
        exit();
    }
}

if(isset($_POST['button'])) {
    $p_id = $_POST['problem_id'];
    $code= $_POST['code'];
    try {
        $stmt = $db->prepare("SELECT `Input`, `Output` FROM `problemset` WHERE `Problem_ID` = ?;");
        $stmt->execute(array($p_id));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $input = NULL;
        $output = NULL;
        if(count($result) > 0){
            $input = $result[0]["Input"];
            $output = $result[0]["Output"];
        } else {
            echo '<script>
            alert("Problem Id is incorrect");
            </script>';
        }
        $result = CurlHelper::perform_http_request("c", "5", $code, $input);
        if(isset($result) && $input != NULL){
            if(strcmp(explode("\"",$result)[3], $output) == 0){
                echo '<script>
                alert("Congratulations! You successfully solved the problem.");
                </script>';
                $stmt = $db->prepare("INSERT INTO `labdata` (`ID`, `Roll`, `ProblemID`, `Verdict`, `Time`) VALUES (NULL, ?, ?, 'Accepted', current_timestamp());");
                $check = $stmt->execute(array($_SESSION['roll'], $p_id));
                if($check == true){
                    echo '<script>
                    alert("The submission has been registered. Move to next problem.");
                    </script>';
                } else {
                    echo '<script>
                    alert("Could not insert the verdict into the db");
                    </script>';
                }

            } else {
                echo '<script>
                alert("The code is incorrect!'.strcmp(explode("\"",$result)[3], $output).'");
                </script>';
            }
        }
        
    }
    catch (PDOException $e){
        echo "Couldn't run statement: " . $e->getMessage();
    }
} else if (isset($_POST['logout'])){
    session_destroy();
    header("Location: index.php", true, 301);
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="compiler.css"></link>
    </head>
<body style="margin-left: 20%; margin-right:20%;">
    <div class="Ticket container">
        <div class="TicketInformation">
            <div class="form-box container-fluid">
            <div class="form-row row">
                <form method="post" action="">    
                <div class="form-group col-md-6">
                    <?php echo '<h2>Welcome <em>'.$_SESSION['name'].'</em></h2>'; ?>
                </div>
                <div class="form-group col-md-6">
                    <input type="submit" name="logout" value="Logout" class="button"  style="display: block; margin-left: auto;  margin-right: 0;"></input>
                </div>
                </form>
            </div>
            
            <div class="row m-2">
            <h3 class="labels">Submit Your Code</h3>
            <form action="" method="post">
                <div class="form-row row">
                <div class="form-group col">
                    <label for="inputEmail4">Problem Number</label>
                    <input type="text" class="form-control" name="problem_id" placeholder="Ex: L4_1" required>
                </div>
                </div>
                <div class="form-row row m-2">
                <div class="form-group col-sm-12 col-lg-12 col-md-12">
                <br>
                <textarea  class="form-control" style="min-width:50px; max-width:100%;min-height:350px;height:100%;width:100%;"  name="code" placeholder="Your C code" required></textarea>
                </div>
                </div>
                <br>
                <div class="form-row row">
                    <input type="submit" name="button" value="Submit" class="button"></input>
                </div>
                <br>
            </form>
            </div>
            </div>
        </div>
    </div>
<body>

<?php 
echo '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  ';
?>
</html>