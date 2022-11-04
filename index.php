<?php 
session_start();
require_once("db.php");

if(isset($_POST["signin"])){
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $password = hash('sha512',$pass);
     // preparing a statement
     try{
        $stmt = $db->prepare("SELECT `Name`, `Roll`, `Email`, `Role` FROM `users` WHERE `email` = ? AND `password` = ?;");

        // execute/run the statement. 
        $stmt->execute(array($email, $password));
    
        // fetch the result. 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        if(count($result) > 0){
            $_SESSION["name"] = $result[0]["Name"];
            $_SESSION["roll"] = $result[0]["Roll"];
            $_SESSION["email"] = $result[0]["Email"];
            $_SESSION["role"] = $result[0]["Role"];
            if($result[0]["Role"] == "student"){
                header("Location: compiler.php", true, 301);
                exit();
            } else if($result[0]["Role"] == "teacher"){
                header("Location: problems.php", true, 301);
                exit();
            }
        } else {
            echo '<script>
              alert("User not present. Please register.");
            </script>';
        }
     } catch (PDOException $e){
        echo "Couldn't run statement: " . $e->getMessage();
     }
} else if (isset($_POST["signup"])){
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $name = $_POST["name"];
    $roll = $_POST["roll"];
    $password = hash('sha512',$pass);
    // preparing a statement
    try{
        $stmt = $db->prepare("INSERT INTO `users` (`ID`, `Name`, `Roll`, `Email`, `Password`, `Role`) VALUES (NULL, ?, ?, ?, ?, 'student');");

        // execute/run the statement. 
        $check = $stmt->execute(array($name, $roll, $email, $password));
        if($check == true){
            $_SESSION["name"] = $name;
            $_SESSION["roll"] = $roll;
            $_SESSION["email"] = $email;
            header("Location: compiler.php", true, 301);
            exit();
        } else {
            echo '<script>
              alert("Couldn\'t register new user");
            </script>';
        }
     } catch (PDOException $e){
        echo "Couldn't insert new user: " . $e->getMessage();
     }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="index.css"></link>
    </head>
<body>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
    crossorigin="anonymous">

<div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="post" id="sign_up">
                <h1>Create Account</h1>
                <input type="text" name="name" placeholder="Name" />
                <input type="number" name="roll" placeholder="Roll" />
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <button name="signup" nclick="insertData()">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="" method="post">
                <h1>Sign in</h1>
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <p>Forgot your password? Contact MMH</p>
                <button name="signin">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Coder!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () =>
    container.classList.add('right-panel-active'));

    signInButton.addEventListener('click', () =>
    container.classList.remove('right-panel-active'));
</script>
</body>
</html>