<?php
$page = "jovian-hair-home";

//init vars
$stat_msg = "";

//conn to db
require_once("../connection/db_conn.php");

$fetch_hair_table_hhw = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = '100% human hair weaves' ORDER BY pid DESC LIMIT 10");
$fetch_hair_table_hhw->execute();

$fetch_hair_table_fw = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = 'Foreign wigs(human hair/fibre)' ORDER BY pid DESC LIMIT 10");
$fetch_hair_table_fw->execute();

$fetch_hair_table_hac = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = 'Hair accessories/cosmetics' ORDER BY pid DESC LIMIT 10");
$fetch_hair_table_hac->execute();

$fetch_hair_table_other = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = 'Others' ORDER BY pid DESC LIMIT 10");
$fetch_hair_table_other->execute();
?>

<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jovian Hair &#124; Jovianbiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="stylesheet" href="../assets/css/jovianhair-style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-grid.min.css"/>
    <link rel="icon" href="../favicon.png" sizes="32x32" type="image/png">
    <meta name="theme-color" content="#00a1ff">
    <meta name="description" content="Jovian Hair provides a wide variety of hair attachments, wigs, weavons, hair accessories and lots more. Get to explore, review and order all of the available products.">
    <meta name="keywords" content="hair, wig, hair attachment, weavon, cosmetics, human hair, human fibre, hair accessories">
    <meta name="robots" content="index, follow">
    
    <link rel="canonical" href="http://www.jovianbiz.com/hair">
    <meta property="og:title" content="Jovian Hair &#124; Jovianbiz">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://www.jovianbiz.com/hair">
    <meta property="og:image" content="http://www.jovianbiz.com/assets/img/jovianbiz_source_image.png">
    <meta property="og:description" content="Jovian Hair provides a wide variety of hair attachments, wigs, weavons, hair accessories and lots more. Get to explore, review and order all of the available products.">
    <meta property="og:site_name" content="Jovianbiz">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="jovianbiz logo">
    <script type="application/Id+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "url": "http://www.jovianbiz.com/hair",
        "name": "Jovianbiz",
        "author": "Grant Adiele",
        "description": "Jovian Hair provides a wide variety of hair attachments, wigs, weavons, hair accessories and lots more. Get to explore, review and order all of the available products.",
        "image": {
            "@id": "http://www.jovianbiz.com/assets/img/jovianbiz_source_image.png",
            "@type": "@id"
        },
        "telephone": "+2348061609674",
        "potentialAction": {
            "@type": "searchAction",
            "target": "http://www.jovianbiz.com/results.php?query={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
</head>
<body>
    <?php require_once("../parts/headernav.php"); 
        if(!empty($_GET["err"])){
            $stat_msg = urldecode($_GET["err"]);
            echo "<div class='site-msg'><h2 class='page-heading'>$stat_msg <a href='index.php' style='color:#00a1ff; background-color:#eee; padding:6px 10px; border-radius:4px; font-weight:bolder; text-decoration:none; font-size:18px;'>Close</a></h2></div>";
        }
    ?>
    
    <div class="jhs-hero">
        <h2 class="jhs-hero-text"><i class="fa fa-quote-left"></i>Beauty is power; a smile is its sword.<i class="fa fa-quote-right"></i> - John Ray.</h2>
    </div>

    <section class="content-section">
        <h1 class="content-section-heading">Jovian Hair</h1>

        <div class="container-fluid">
            <h3 class="category-heading">100% human hair weaves</h3>
            <a href='category.php?cat=h_h_w' class='view-more-link'>View more <i class='fa fa-arrow-right'></i></a>
            <div class="row">
                <?php
                    if($fetch_hair_table_hhw->rowCount() >= 1){
                        while($row_hhw = $fetch_hair_table_hhw->fetch(PDO::FETCH_ASSOC)){
                            $db_pid = $row_hhw["pid"];
                            $db_product_name = $row_hhw["product_name"];
                            $db_product_tag = $row_hhw["product_tag"];
                            $db_product_availability = $row_hhw["product_availability"];
                            $db_product_price = $row_hhw["product_price"];
                            $db_product_image = $row_hhw["product_img_1"];
                            echo "<div class='col-6 col-md-3 col-lg-2'>
                                 <div class='jhs-content-container'>
                                    <a href='product.php?pid=$db_pid'>
                                        <img src='../uploads/$db_product_image'>
                                        <ul>
                                            <li title='$db_product_name'>$db_product_name</li>
                                            <li title='$db_product_tag'>$db_product_tag</li>
                                            <li title='$db_product_price'>$db_product_price</li>
                                            <li>$db_product_availability</li>
                                        </ul>
                                    </a>
                                </div>
                            </div>";
                        }
                    }else{
                        echo "<h2 class='col-12 empty-section-msg'>There are no products available in this category.</h2>";
                    }
                ?>
            </div>
        </div>

        <div class="container-fluid">
            <h3 class="category-heading">Foreign wigs (human hair/fibre)</h3>
            <a href='category.php?cat=f_w' class='view-more-link'>View more <i class='fa fa-arrow-right'></i></a>
            <div class="row">
                <?php
                    if($fetch_hair_table_fw->rowCount() >= 1){
                        echo "";
                        while($row_fw = $fetch_hair_table_fw->fetch(PDO::FETCH_ASSOC)){
                            $db_pid = $row_fw["pid"];
                            $db_product_name = $row_fw["product_name"];
                            $db_product_tag = $row_fw["product_tag"];
                            $db_product_availability = $row_fw["product_availability"];
                            $db_product_price = $row_fw["product_price"];
                            $db_product_image = $row_fw["product_img_1"];
                            echo "<div class='col-6 col-md-3 col-lg-2'>
                                 <div class='jhs-content-container'>
                                    <a href='product.php?pid=$db_pid'>
                                        <img src='../uploads/$db_product_image'>
                                        <ul>
                                            <li title='$db_product_name'>$db_product_name</li>
                                            <li title='$db_product_tag'>$db_product_tag</li>
                                            <li title='$db_product_price'>$db_product_price</li>
                                            <li>$db_product_availability</li>
                                        </ul>
                                    </a>
                                </div>
                            </div>";
                        }
                    }else{
                        echo "<h2 class='col-12 empty-section-msg'>There are no products available in this category.</h2>";
                    }
                ?>
            </div>
        </div>
        
        <div class="container-fluid">
            <h3 class="category-heading">Hair accessories/cosmetics</h3>
            <a href='category.php?cat=h_a_c' class='view-more-link'>View more <i class='fa fa-arrow-right'></i></a>
            <div class="row">
                <?php
                    if($fetch_hair_table_hac->rowCount() >= 1){
                        while($row_hac = $fetch_hair_table_hac->fetch(PDO::FETCH_ASSOC)){
                            $db_pid = $row_hac["pid"];
                            $db_product_name = $row_hac["product_name"];
                            $db_product_tag = $row_hac["product_tag"];
                            $db_product_availability = $row_hac["product_availability"];
                            $db_product_price = $row_hac["product_price"];
                            $db_product_image = $row_hac["product_img_1"];
                            echo "<div class='col-6 col-md-3 col-lg-2'>
                                <div class='jhs-content-container'>
                                    <a href='product.php?pid=$db_pid'>
                                        <img src='../uploads/$db_product_image'>
                                        <ul>
                                            <li title='$db_product_name'>$db_product_name</li>
                                            <li title='$db_product_tag'>$db_product_tag</li>
                                            <li title='$db_product_price'>$db_product_price</li>
                                            <li>$db_product_availability</li>
                                        </ul>
                                    </a>
                                </div>
                            </div>";
                        }
                    }else{
                        echo "<h2 class='col-12 empty-section-msg'>There are no products available in this category.</h2>";
                    }
                ?>
            </div>
        </div>


        <div class="container-fluid">
            <h3 class="category-heading">Others</h3> 
            <a href='category.php?cat=others' class='view-more-link'>View more <i class='fa fa-arrow-right'></i></a>
            <div class="row">
                <?php
                    if($fetch_hair_table_other->rowCount() >= 1){
                        while($row_other = $fetch_hair_table_other->fetch(PDO::FETCH_ASSOC)){
                            $db_pid = $row_other["pid"];
                            $db_product_name = $row_other["product_name"];
                            $db_product_tag = $row_other["product_tag"];
                            $db_product_availability = $row_other["product_availability"];
                            $db_product_price = $row_other["product_price"];
                            $db_product_image = $row_other["product_img_1"];
                            echo "<div class='col-6 col-md-3 col-lg-2'>
                                 <div class='jhs-content-container'>
                                    <a href='product.php?pid=$db_pid'>
                                        <img src='../uploads/$db_product_image'>
                                        <ul>
                                            <li title='$db_product_name'>$db_product_name</li>
                                            <li title='$db_product_tag'>$db_product_tag</li>
                                            <li title='$db_product_price'>$db_product_price</li>
                                            <li>$db_product_availability</li>
                                        </ul>
                                    </a>
                                </div>
                            </div>";
                        }
                    }else{
                        echo "<p class='col-12 empty-section-msg'>There are no products available in this category.</p>";
                    }
                ?>
            </div>
        </div>
        
    </section>

    <?php require_once("../parts/footer.php"); ?>

    <script src="../assets/js/script.js"></script>
</body>
</html>