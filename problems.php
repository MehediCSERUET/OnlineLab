<?php
session_start();
require_once("curl_helper.php");
require_once("db.php");

if(!isset($_SESSION) || $_SESSION['role'] != "teacher"){
    header("Location: index.php", true, 301);
    exit();
}

if(isset($_POST['button'])) {
    $p_id = $_POST['problem_id'];
    $input= $_POST['input'];
    $output = $_POST['output'];
    try {
            $stmt = $db->prepare("INSERT INTO `problemset` (`ID`, `Problem_ID`, `Input`, `Output`) VALUES (NULL, ?, ?, ?);");
            $check = $stmt->execute(array($p_id, $input, $output));
            if($check == true){
                echo '<script>
                alert("The problem has been registered into database. Move to next problem.");
                </script>';
            } else {
                echo '<script>
                alert("Could not insert the problem into the db");
                </script>';
            }
    } catch (PDOException $e){
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
        <link rel="stylesheet" href="problems.css"></link>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script>
            function showLeaders() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
                };
                xmlhttp.open("GET","getleader.php",true);
                xmlhttp.send();
            }

            function approveStudents() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("status").innerHTML = this.responseText;
                }
                };
                xmlhttp.open("GET","approve.php?q="+document.getElementById("status").innerHTML,true);
                xmlhttp.send();
            }

            function users() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("userData").innerHTML = this.responseText;
                }
                };
                xmlhttp.open("GET","userData.php",true);
                xmlhttp.send();
            }

            window.onload = function(){  
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("status").innerHTML = this.responseText;
                }
                };
                xmlhttp.open("GET","getStatus.php",true);
                xmlhttp.send();
            }
        </script>
    </head>
<body style="margin-left: 20%; margin-right:20%;">
    <div class="Ticket container">
        <div class="TicketInformation container-fluid">
            <div class="form-box container">

            
            <form method="post" action="">
                <div class="row m-2">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                    <?php echo '<h2 style="font-size: 130%;">Welcome <em>'.$_SESSION['name'].'</em></h2>'; ?>
                    </div>
                </div>
            <div class="row m-2">
                <div class="col-md-3 col-lg-3 col-sm-12">
                <input type="button" name="approve" value="Users" id="USERInfo" class="btn btn-primary m-1 btn-block" data-toggle="modal" data-target="#exampleModal2" onclick="users()"></input>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12">
                <button type="button" name="approve" id="status" class="btn btn-primary m-1 btn-block" onclick="approveStudents()"></button>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12">
                <input type="button" name="leaderboard" value="Leaderboard" class="btn btn-primary m-1 btn-block" data-toggle="modal" data-target="#exampleModal" onclick="showLeaders()"></input>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12">
                <input type="submit" name="logout" value="Logout" class="btn btn-primary m-1 btn-block"></input>
                </div>
            </div>
            </form>
            <div class="row m-2">
                <div class="col">
                    <h4 class="labels">Submit Your Problems</h4>
            </div>
            </div>
            <div class="row m-2">
            <form action="" method="post">
                <div class="form-row row m-2">
                <div class="form-group col">
                    <label for="inputEmail4">Problem Number</label>
                    <input type="text" class="form-control" name="problem_id" placeholder="Ex: L4_1" required>
                </div>
                </div>
                <div class="form-row row m-2">
                <div class="form-group col">
                <br>
                <textarea class="form-control rounded-0" rows="5" cols="113" name="input" placeholder="Input for the problem, if any"></textarea>
                </div>
                </div>


                <div class="form-row row m-2">
                <div class="form-group col">
                <br>
                <textarea class="form-control rounded-0" rows="5" cols="113" name="output" placeholder="Output for the problem" required></textarea>
                </div>
                </div>

                <br>
                <div class="form-row row m-2">
                    <div class="col">
                    <input type="submit" name="button" value="Submit" class="button"></input>
                    </div>
                </div>
                <br>
            </form>
        </div>
            
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Leaderboard</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
             <div id="txtHint"><b>Leader info will be listed here...</b></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
             <div id="userData"><b>User info will be listed here...</b></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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