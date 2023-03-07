<?php
session_start();

if(!isset($_SESSION["uid"])){
    header("Location: login.php");
}

//init vars
$__MSG = $error = $pa_select = $pt_select_1 = $pt_select_2 = $pt_select_3 = "";

//conn to db
require_once("../connection/db_conn.php");

if(isset($_GET['pid']) && !empty($_GET['pid']) && $_GET['type'] == 'jh'){
    $pid = $_GET['pid'];
    $fetch_hair_post_details = $conn->prepare("SELECT pid,product_name,product_tag,product_availability,product_price,product_desc,date_time FROM _jb_hair_post WHERE pid = :pid");
    $fetch_hair_post_details->bindParam(":pid", $pid);
    $fetch_hair_post_details->execute();

    $error = 0;

    $row = $fetch_hair_post_details->fetch(PDO::FETCH_ASSOC);
    //check if post exist in db
    if(empty($row['pid']) && !is_numeric($row['pid'])){
        $__MSG = "This page is feeling a little bit empty, the post you are looking for may have been deleted or does not exist on this site. <a href='index.php' style='color:#00a1ff; background-color:#eee; padding:6px 10px; border-radius:4px; font-weight:bolder; text-decoration:none; font-size:18px;'>Go Home</a>";

        $error = 1;
    }

    $db_product_name = $row['product_name'];
    $db_product_tag = $row['product_tag'];
    $db_product_availability = $row['product_availability'];
    $db_product_price = $row['product_price'];
    $db_product_desc = $row['product_desc'];
    $db_date_time = $row['date_time'];

    if($db_product_tag == 'Foreign wigs(human hair/fibre)'){
        $pt_select_1 = 'selected';
    }elseif($db_product_tag == 'Hair accessories/cosmetics'){
        $pt_select_2 = 'selected';
    }elseif($db_product_tag == 'Others'){
        $pt_select_3 = 'selected';
    }

    if($db_product_availability == 'Unavailable'){
        $pa_select = 'selected';
    }

    //update product
    if($_POST){
        $update_hair_product = $conn->prepare("UPDATE _jb_hair_post SET product_name = :product_name, product_tag = :product_tag, product_availability = :product_availability, product_price = :product_price, product_desc = :product_desc WHERE pid = :pid");
        $update_hair_product->bindParam(":pid", $pid);
        $update_hair_product->bindParam(":product_name", $_POST["product_name"]);
        $update_hair_product->bindParam(":product_tag", $_POST["product_tag"]);
        $update_hair_product->bindParam(":product_availability", $_POST["product_availability"]);
        $update_hair_product->bindParam(":product_price", $_POST["product_price"]);
        $update_hair_product->bindParam(":product_desc", $_POST["product_desc"]);

        if($update_hair_product->execute()){
            $__MSG = "Product details successfully updated.";
        }else{
            $__MSG = "Unable to update product details.";
        }
    }
    
}else{
    $__MSG = "This page is feeling a little bit empty, the post you are looking for may have been deleted or does not exist on this site. <a href='index.php' style='color:#00a1ff; background-color:#eee; padding:6px 10px; border-radius:4px; font-weight:bolder; text-decoration:none; font-size:18px;'>Go Home</a>";

    $error = 1;
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
    <title>Edit Hair Post &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php require_once("parts/headernav.php");
    if($error == 0){
        echo "<h2 class='page-heading'>You are unable to update <strong>screenshots</strong>. You may need to entirely delete this post &amp; repost it with correct details. <a href='delete.php?pid=$pid&type=jh' style='color:#eee; background-color:#ff7700; padding:6px 10px; border-radius:4px; font-weight:bolder; text-decoration:none; font-size:18px;'>Delete</a></h2>";
    }

    if(!empty($__MSG)){
        echo "<div class='site-msg'>$__MSG</div>";
    }
?>

<a href='hair-table.php' style="background-color:#000; display:block; margin:5px auto; padding:12px 8px; width:fit-content; color:#fff; text-decoration:none; text-align:center; cursor:pointer;"><i class='fa fa-arrow-circle-left'></i> Go Back</a>

    <?php
    if($error == 0){
        echo "<div class='wrapper-container'>
            <h2>Edit Product</h2>
            <form action='' method='post' enctype='multipart/form-data'>
                <input type='text' name='product_name' placeholder='Product name' value='$db_product_name' autocomplete='off' required>

                <select name='product_tag' required>
                    <option value='100% human hair weaves'>100% human hair weaves</option>
                    <option value='Foreign wigs(human hair/fibre)' $pt_select_1>Foreign wigs(human hair/fibre)</option>
                    <option value='Hair accessories/cosmetics' $pt_select_2>Hair accessories/cosmetics</option>
                    <option value='Others' $pt_select_3>Others</option>
                </select>

                <select name='product_availability' required>
                    <option value='Available'>Available</option>
                    <option value='Unavailable' $pa_select>Unavailable</option>
                </select>

                <input type='text' name='product_price' placeholder='Price' value='$db_product_price' autocomplete='off' required>

                <textarea name='product_desc' placeholder='Product description' autocomplete='off' required style='resize:vertical; height:150px; font-family:inherit;'>$db_product_desc</textarea>

                <input type='hidden' name='datetime' value='$db_date_time'>

                <input type='submit' value='Update Product'>
            </form>

        </div>";
    }
    ?>

    <script src="../assets/js/script.js"></script>
</body>
</html>