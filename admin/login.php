<?php
session_start();

//init vars
$__MSG = "";

//conn db
require_once("../connection/db_conn.php");

if(isset($_SESSION["uid"])){
    header("Location: index.php");
}

if(!empty($_POST["useremail"]) && !empty($_POST["userpassword"])){
    $records = $conn->prepare("SELECT aid,email,psw FROM _jb_admins WHERE email = :email");
    $records->bindParam(":email", $_POST["useremail"]);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    //equate var results to empty array
    if(empty($results)){
        $results = array();
    }

    if(count($results) > 0 && password_verify($_POST["userpassword"], $results["psw"])){
        $_SESSION["uid"] = $results["aid"];
        header("Location: index.php");
    }else{
        $__MSG = "Incorrect Password or Email address!";
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
    <title>Login &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php
    if(!empty($__MSG)){
        echo "<div class='site-msg'>$__MSG</div>";
    }
?>

<div class="wrapper-container">
    <h2>Jovianbiz Admin Login</h2>
    <form action='' method='post' enctype='multipart/form-data'>
        <input type='email' name='useremail' placeholder='Email' autocomplete='off' required>

        <input type='password' name='userpassword' placeholder='Password' autocomplete='off' required>
        
        <input type='submit' value='Login'>
        <div style='text-align:center; margin:20px auto;'>
            <a href="../index.php">Go Home</a>
        </div>
    </form>

</div>

</body>
</html>