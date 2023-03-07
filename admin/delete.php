<?php
session_start();

if(!isset($_SESSION["uid"])){
    header("Location: login.php");
}

//init vars
$__MSG = $gen_error = "";

//conn to db
require_once("../connection/db_conn.php");

if(isset($_GET["pid"]) && !empty($_GET["pid"])){
    $gen_error = 0;

    $link_pid = $_GET["pid"];
    //get post info
    $fetch_hair_info = $conn->prepare("SELECT pid,product_name,product_img_1,product_img_2,product_img_3 FROM _jb_hair_post WHERE pid = :pid");
    $fetch_hair_info->bindParam(":pid", $link_pid);
    $fetch_hair_info->execute();
    $row = $fetch_hair_info->fetch(PDO::FETCH_ASSOC);
    $db_name = $row["product_name"];
    $db_product_img_1 = $row["product_img_1"];
    $db_product_img_2 = $row["product_img_2"];
    $db_product_img_3 = $row["product_img_3"];
    $suffix = "hair table";

    $delete_link = "delete.php?pid=$link_pid&type=jh&action=true";
    $back_link = "hair-table.php";

    //check if post exists in db
    if(empty($row['pid']) && !is_numeric($row['pid'])){
        $__MSG = "This page is feeling a little bit empty, the post you are looking for may have been deleted or does not exist on this site. <a href='index.php' style='color:#00a1ff; background-color:#eee; padding:6px 10px; border-radius:4px; font-weight:bolder; text-decoration:none; font-size:18px;'>Go Home</a>";
        $gen_error = 1;
    }

    //delete stmt
    $delete_hair_post = $conn->prepare("DELETE FROM _jb_hair_post WHERE pid = :pid");
    $delete_hair_post->bindParam(":pid", $link_pid);
    if(isset($_GET["action"]) && $_GET["type"] == "jh"){
        if($_GET["action"] == "true"){
            if($delete_hair_post->execute()){
                //delete uploaded img
                if(file_exists("../uploads/$db_product_img_1")){
                    unlink("../uploads/$db_product_img_1");
                }
                if(file_exists("../uploads/$db_product_img_2")){
                    unlink("../uploads/$db_product_img_2");
                }
                if(file_exists("../uploads/$db_product_img_3")){
                    unlink("../uploads/$db_product_img_3");
                }
                header("Location: hair-table.php?stat=Product with product ID $link_pid deleted successfully.");
            }else{
                $__MSG = "Unable to delete post. Something went wrong.";
            }
    
        }
    }

}else{
    $__MSG = "This page is feeling a little bit empty, the post you are looking for may have been deleted or does not exist on this site. <a href='index.php' style='color:#00a1ff; background-color:#eee; padding:6px 10px; border-radius:4px; font-weight:bolder; text-decoration:none; font-size:18px;'>Go Home</a>";
    $gen_error = 1;
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
    <title>Delete Action &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php require_once("parts/headernav.php"); 
    if(!empty($__MSG)){
        echo "<div class='site-msg'>$__MSG</div>";
    }
?>

<?php
    if($gen_error == 0){
        echo "<div class='wrapper-container'>
            <h2>Are you sure you want to delete \"$db_name\" from $suffix ?</h2>

            <form action='' method='post' enctype='multipart/form-data'>
                <div style='text-align:center; margin:20px auto;'>
                    <a href='$delete_link' style='color:#f00;'>Delete</a>
                </div>
                <div style='text-align:center;'>
                    <a href='$back_link' style='color:#000;'>Cancel</a>
                </div>
            </form>
        </div>";
    }
?>

    <script src="../assets/js/script.js"></script>
</body>
</html>