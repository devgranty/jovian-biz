<?php
session_start();

if(!isset($_SESSION["uid"])){
    header("Location: login.php");
}

//conn to db
require_once("../connection/db_conn.php");

$count_product_tag_1 = $conn->query("SELECT COUNT(pid) FROM _jb_hair_post WHERE product_tag = '100% human hair weaves'");
$number_of_tag_1 = $count_product_tag_1->fetchColumn();

$count_product_tag_2 = $conn->query("SELECT COUNT(pid) FROM _jb_hair_post WHERE product_tag = 'Foreign wigs(human hair/fibre)'");
$number_of_tag_2 = $count_product_tag_2->fetchColumn();

$count_product_tag_3 = $conn->query("SELECT COUNT(pid) FROM _jb_hair_post WHERE product_tag = 'Hair accessories/cosmetics'");
$number_of_tag_3 = $count_product_tag_3->fetchColumn();

$count_product_tag_4 = $conn->query("SELECT COUNT(pid) FROM _jb_hair_post WHERE product_tag = 'Others'");
$number_of_tag_4 = $count_product_tag_4->fetchColumn();

$count_product_tag_5 = $conn->query("SELECT COUNT(pid) FROM _jb_hair_post");
$number_of_tag_5 = $count_product_tag_5->fetchColumn();

$count_admins = $conn->query("SELECT COUNT(aid) FROM _jb_admins");
$number_of_admins = $count_admins->fetchColumn();
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
    <title>Dashboard &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php require_once("parts/headernav.php"); ?>


    <div>
        <h2 style="text-align:center;">Dashboard</h2>

        <div class="details-container">
            <h3>Jovian Hair Statistics</h3>
            <ul>
                <li>100% human hair weaves: <span><?php echo $number_of_tag_1; ?></span></li>
                <li>Foreign wigs(human hair/fibre): <span><?php echo $number_of_tag_2; ?></span></li>
                <li>Hair accessories/cosmetics: <span><?php echo $number_of_tag_3; ?></span></li>
                <li>Others: <span><?php echo $number_of_tag_4; ?></span></li>
                <li>Total Hair posts: <span><?php echo $number_of_tag_5; ?></span></li>
            </ul>
        </div>

        <div class="details-container">
            <h3>Jovian Admin Statistics</h3>
            <ul>
                <li>Number of registered admin: <span><?php echo $number_of_admins; ?></span></li>
            </ul>
        </div>

    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>