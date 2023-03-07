<?php
$page = "";

//conn to db
require_once("../connection/db_conn.php");
//require functions
require_once("../parts/function.php");

if(isset($_GET["pid"]) && !empty($_GET["pid"])){
    $pid = $_GET["pid"];
    $fetch_hair_post_details = $conn->prepare("SELECT * FROM _jb_hair_post WHERE pid = :pid");
    $fetch_hair_post_details->bindParam(":pid", $pid);
    $fetch_hair_post_details->execute();

    //check if post exists in db
    $row = $fetch_hair_post_details->fetch(PDO::FETCH_ASSOC);

    if(empty($row['pid']) && !is_numeric($row['pid'])){
        $encode_errmsg = urlencode("The page you are trying to view is feeling a little bit empty, it may have been deleted or does not exist on this site.");
        header("Location: index.php?err=$encode_errmsg");
        exit();
    }

    $db_product_name = $row['product_name'];
    $db_product_tag = $row['product_tag'];
    $db_product_availability = $row['product_availability'];
    $db_product_price = $row['product_price'];
    $db_product_desc = $row['product_desc'];
    $db_date_time = $row['date_time'];
    $db_product_img_1 = $row['product_img_1'];
    $db_product_img_2 = $row['product_img_2'];
    $db_product_img_3 = $row['product_img_3'];

    //contact whatsapp msg
    $contact_msg = urlencode("Hello, Please I am interested in this product \"$db_product_name\" and it is $db_product_availability. How can I get it? \nhttp://www.jovianbiz.com/hair/product.php?pid=$pid");

    //change some vals
    if($db_product_availability == "Available"){
        $db_product_availability = "<span id='jh-valid'>Available</span>";
    }else{
        $db_product_availability = "<span id='jh-invalid'>Unavailable</span>";
    }

}else{
    $encode_errmsg = urlencode("The page you are trying to view is feeling a little bit empty, it may have been deleted or does not exist on this site.");
    header("Location: index.php?err=$encode_errmsg");
    exit();
}
?>

<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $db_product_name; ?> &#124; Jovianbiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/jovianhair-style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-grid.min.css"/>
    <link rel="icon" href="../favicon.png" sizes="32x32" type="image/png">
    <meta name="theme-color" content="#00a1ff">
    <meta name="description" content='<?php echo "Get to order &amp; buy $db_product_name ($db_product_desc)"; ?>'>
    <meta name="keywords" content='<?php echo "$db_product_name, $db_product_tag, hair accessories, hair"; ?>'>
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="http://www.jovianbiz.com/hair/product.php?pid=<?php echo $pid; ?>">
    <meta property="og:title" content="<?php echo $db_product_name; ?> &#124; Jovianbiz">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://www.jovianbiz.com/hair/product.php?pid=<?php echo $pid; ?>">
    <meta property="og:image" content="http://www.jovianbiz.com/uploads/<?php echo $db_product_img_1; ?>">
    <meta property="og:description" content='<?php echo "Get to order &amp; buy $db_product_name ($db_product_desc)" ?>'>
    <meta property="og:site_name" content="Jovianbiz">
    <meta property="og:image:type" content="image/<?php echo get_image_ext($db_product_img_1); ?>">
    <meta property="og:image:alt" content="An image of <?php echo $db_product_name; ?>.">
</head>
<body>
    <?php require_once("../parts/headernav.php"); ?>

    <section class="content-section" style="background-color:#eee;">
            <header><h1 style="color:#00a1ff;"><?php echo $db_product_name; ?></h1></header>
            
            <h2 class="product-page-sub-title">Image</h2>

            <div class="container-fluid">
                <div class="row">
                    <?php
                        if($db_product_img_1 != "empty"){
                            echo "<div class='col-12 col-md-3 col-md-4'>
                                <img src='../uploads/$db_product_img_1' width='100%'>
                            </div>";
                        }

                        if($db_product_img_2 != "empty"){
                            echo "<div class='col-12 col-md-3 col-md-4'>
                                <img src='../uploads/$db_product_img_2' width='100%'>
                            </div>";
                        }
                        if($db_product_img_3 != "empty"){
                            echo "<div class='col-12 col-md-3 col-md-4'>
                                <img src='../uploads/$db_product_img_3' width='100%'>
                            </div>";
                        }
                    ?>
                </div>
            </div>

            <h2 class="product-page-sub-title">Product Details</h2>

            <ul class="product-details-ul">
                <li><label for="addedon">Added on:</label> <?php echo $db_date_time; ?></li>

                <li><label for="availablity">Availablity:</label> <?php echo $db_product_availability; ?></li>

                <li><label for="category">Category:</label> <?php echo $db_product_tag; ?></li>

                <li><label for="desc">Description:</label> <?php echo $db_product_desc; ?></li>

                <li><label for="price">Price:</label> <?php echo $db_product_price; ?></li>
            </ul>

            <h2 class="product-page-sub-title">Order Product</h2>

            <div style="text-align:center; color:#00a1ff; font-size:13px;">
                <i>You can use either of the contacts to order this product:</i>
            </div>

            <div class="order-section">
                <a href="tel:+2348061609674" style="background-color:#00a1ff;"><i class="fa fa-phone-square"></i> Call</a>

                <a href="https://api.whatsapp.com/send?phone=2348061609674&text=<?php echo $contact_msg; ?>" target="_blank" style="background-color:#00a199;"><i class="fa fa-whatsapp"></i> WhatsApp</a>
            </div>
    </section>

    <?php require_once("../parts/footer.php"); ?>

     <!-- Go to www.addthis.com/dashboard to customize your tools -->
     <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c314c3076a44c45"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
