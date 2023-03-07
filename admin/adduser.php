<?php
session_start();

if(!isset($_SESSION["uid"])){
    header("Location: login.php");
}

//init vars
$__MSG = "";

//conn to db
require_once("../connection/db_conn.php");


if($_POST){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $psw1 = $_POST["password"];
    $psw2 = $_POST["cpassword"];
    $datetime = $_POST["datetime"];

    $hash = password_hash($psw1, PASSWORD_BCRYPT);

    $adduser = $conn->prepare("INSERT INTO _jb_admins (username, email, psw, date_time) VALUES (:username, :email, :psw, :date_time)");
    $adduser->bindParam(":username", $username);
    $adduser->bindParam(":email", $email);
    $adduser->bindParam(":psw", $hash);
    $adduser->bindParam(":date_time", $datetime);

    if($psw1 == $psw2){
        if($adduser->execute()){
            $__MSG = "User account created successfully.";
        }else{
            $__MSG = "Something went wrong, Unable to create user account.";
        }
    }else{
        $__MSG = "Error: Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/jovianhair-style.css" />
    <link rel="icon" href="../favicon.png" sizes="32x32" type="image/png">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adduser &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php require_once("parts/headernav.php"); 
    if(!empty($__MSG)){
        echo "<div class='site-msg'>$__MSG</div>";
    }
?>

    <div class="wrapper-container">
        <h2>Create an account</h2>
        <form action='' method='post' enctype='multipart/form-data'>
            <input type='text' name='username' placeholder='Username' autocomplete='off' required>

            <input type='email' name='email' placeholder='Email' autocomplete='off' required>

            <input type='password' name='password' placeholder='Password' autocomplete='off' required>

            <input type='password' name='cpassword' placeholder='Confirm Password' autocomplete='off' required>

            <input type='hidden' name='datetime' value="<?php echo date("jS M Y \a\\t g:ia");?>">

            <input type='submit' value='Create account'>
        </form>

    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>