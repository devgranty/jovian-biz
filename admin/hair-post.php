<?php
session_start();

if(!isset($_SESSION["uid"])){
    header("Location: login.php");
}

//init vars
$__MSG = $all_new_names = $error = "";
$screenshot_1 = $screenshot_2 = $screenshot_3 = "empty";

//conn to db
require_once("../connection/db_conn.php");

if($_POST){
    //prepare every other post details
    $product_name = $_POST['product_name'];
    $product_tag = $_POST['product_tag'];
    $product_availability = $_POST['product_availability'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $date_time = $_POST['datetime'];

    $output = "";
    if(is_array($_FILES)){
        foreach($_FILES['product_img']['name'] as $key => $value){    
            if(!empty($_FILES['product_img']['name'][$key])){
                $file_name = explode(".", $_FILES['product_img']['name'][$key]);
                $file_ext = end($file_name);
                $file_size = $_FILES['product_img']['size'][$key];
                $allowed_ext = array("jpeg", "jpg", "png", "gif");

                if(in_array($file_ext, $allowed_ext)){

                    if($file_size < 1024 * 1024 * 3){//File size limit = 3MB
                        $new_image = "";
                        $new_name = md5(rand()).".".$file_ext;
                        $source_path = $_FILES['product_img']['tmp_name'][$key];
                        $target_path = "../uploads/".$new_name;
                        $all_new_names .= $new_name."*";

                        list($width, $height) = getimagesize($source_path);
                        if($file_ext == 'png'){
                            $new_image = imagecreatefrompng($source_path);
                        }
                        if($file_ext == 'jpg' || $file_ext == 'jpeg'){
                            $new_image = imagecreatefromjpeg($source_path);
                        }
                        if($file_ext == 'gif'){
                            $new_image = imagecreatefromgif($source_path);
                        }

                        $new_width = 200;
                        $new_height = ($height/$width)*200;

                        $tmp_image = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($tmp_image, $new_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                        if(imagejpeg($tmp_image, $target_path, 90)){
                            $output .= "<img src='$target_path' width='320' height='240'>";
                            $error = 0;
                        }else{
                            $__MSG = "Error: Unable to upload images. Post cancelled.";
                            $error = 1;   
                        }

                        imagedestroy($new_image);
                        imagedestroy($tmp_image);

                    }else{
                        $__MSG = "Error: An image size is greater than 3MB.";//3MB file size
                        $error = 1;
                    }

                }else{
                    $__MSG = "Error: Invalid image type.";
                    $error = 1;
                }
            }
        }
    }

    //get image new names as arrays
    $new_names = explode("*", $all_new_names);

    if(empty($new_names[0])){
        $screenshot_1 = "empty";
    }else{
        $screenshot_1 = $new_names[0];
    }

    if(empty($new_names[1])){
        $screenshot_2 = "empty";
    }else{
        $screenshot_2 = $new_names[1];
    }

    if(empty($new_names[2])){
        $screenshot_3 = "empty";
    }else{
        $screenshot_3 = $new_names[2];
    }

    $upload_hair_post = $conn->prepare("INSERT INTO _jb_hair_post (product_name, product_tag, product_availability, product_price, product_desc, product_img_1, product_img_2, product_img_3, date_time) VALUES (:prod_name, :prod_tag, :prod_avail, :prod_price, :prod_desc, :prod_img_1, :prod_img_2, :prod_img_3, :date_time)");
    
    $upload_hair_post->bindParam(":prod_name", $product_name);
    $upload_hair_post->bindParam(":prod_tag", $product_tag);
    $upload_hair_post->bindParam(":prod_avail", $product_availability);
    $upload_hair_post->bindParam(":prod_price", $product_price);
    $upload_hair_post->bindParam(":prod_desc", $product_desc);
    $upload_hair_post->bindParam(":prod_img_1", $screenshot_1);
    $upload_hair_post->bindParam(":prod_img_2", $screenshot_2);
    $upload_hair_post->bindParam(":prod_img_3", $screenshot_3);
    $upload_hair_post->bindParam(":date_time", $date_time);

    if($error == 0){
        if($upload_hair_post->execute()){
            $__MSG = "Post uploaded successfully.";
        }else{
            $__MSG = "Unable to upload post. Something went wrong.";
            //delete uploaded img
            if(file_exists("../uploads/$screenshot_1")){
                unlink("../uploads/$screenshot_1");
            }
            if(file_exists("../uploads/$screenshot_2")){
                unlink("../uploads/$screenshot_2");
            }
            if(file_exists("../uploads/$screenshot_3")){
                unlink("../uploads/$screenshot_3");
            }
        }
    }else{
        //delete uploaded img
        if(file_exists("../uploads/$screenshot_1")){
            unlink("../uploads/$screenshot_1");
        }
        if(file_exists("../uploads/$screenshot_2")){
            unlink("../uploads/$screenshot_2");
        }
        if(file_exists("../uploads/$screenshot_3")){
            unlink("../uploads/$screenshot_3");
        }
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
    <title>Hair Post &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php require_once("parts/headernav.php");

    if(!empty($__MSG)){
        echo "<div class='site-msg'>$__MSG</div>";
    }

    if(!empty($output)){
        echo "<div style='width:fit-content;margin:auto;'>$output</div>";
    }
?>

    <div class="wrapper-container">
        <h2>Post Product</h2>
        <form action='' method='post' enctype='multipart/form-data'>
            <input type='text' name='product_name' placeholder='Product name' autocomplete='off' required>

            <label>Add screenshots(max 3)[max filesize 3MB]:</label>
            <input type='file' name='product_img[]' required>
            <input type='file' name='product_img[]'>
            <input type='file' name='product_img[]'>

            <select name='product_tag' required>
                <option value="100% human hair weaves">100% human hair weaves</option>
                <option value="Foreign wigs(human hair/fibre)">Foreign wigs(human hair/fibre)</option>
                <option value="Hair accessories/cosmetics">Hair accessories/cosmetics</option>
                <option value="Others">Others</option>
            </select>

            <select name='product_availability' required>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>

            <input type='text' name='product_price' placeholder='Price' autocomplete='off' required>

            <textarea name='product_desc' placeholder='Product description' autocomplete='off' required style="resize:vertical; height:150px; font-family:inherit;"></textarea>

            <input type='hidden' name='datetime' value="<?php echo date("jS M \a\\t g:ia");?>">

            <input type='submit' value='Post Product' id="uploadPostBtn" onclick="uploadProcess()">
        </form>

    </div>

    <script>
        function uploadProcess(){
            var submitBtn = document.getElementById("uploadPostBtn");
            submitBtn.style.background = "#f00";
            submitBtn.value = "Please wait while upload is in progress...";
        }
        
    </script>

    <script src="../assets/js/script.js"></script>
</body>
</html>