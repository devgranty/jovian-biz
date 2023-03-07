<?php
$page = "";

//init vars
$cat_title = $cat_stmt = "";
$_cat = "all";

//conn to db
require_once("../connection/db_conn.php");

if(isset($_GET["cat"]) && !empty($_GET["cat"])){
    $_cat = $_GET["cat"];

    if($_cat == "h_h_w"){
        $fetch_hair_cat = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = '100% human hair weaves' ORDER BY pid DESC");
        $cat_title = "100% human hair weaves";
        $cat_stmt = "WHERE product_tag = '100% human hair weaves'";

    }elseif($_cat == "f_w"){
        $fetch_hair_cat = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = 'Foreign wigs(human hair/fibre)' ORDER BY pid DESC");
        $cat_title = "Foreign wigs(human hair/fibre)";
        $cat_stmt = "WHERE product_tag = 'Foreign wigs(human hair/fibre)'";

    }elseif($_cat == "h_a_c"){
        $fetch_hair_cat = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = 'Hair accessories/cosmetics' ORDER BY pid DESC");
        $cat_title = "Hair accessories/cosmetics";
        $cat_stmt = "WHERE product_tag = 'Hair accessories/cosmetics'";

    }elseif($_cat == "others"){
        $fetch_hair_cat = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_tag = 'Others' ORDER BY pid DESC");
        $cat_title = "Others";
        $cat_stmt = "WHERE product_tag = 'Others'";

    }else{
        $fetch_hair_cat = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post ORDER BY pid DESC");
        $cat_title = "All products";
        $cat_stmt = "";
    }
}else{
        $fetch_hair_cat = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post ORDER BY pid DESC");
        $cat_title = "All products";
        $cat_stmt = "";
}
$fetch_hair_cat->execute();
$countResults = $fetch_hair_cat->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Category &#124; Jovianbiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/jovianhair-style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-grid.min.css"/>
    <link rel="icon" href="../favicon.png" sizes="32x32" type="image/png">
    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
    <meta name="theme-color" content="#00a1ff">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <style type="text/css">
        .j-sub-link{display:-ms-flexbox; display:flex; -ms-flex-direction:row; flex-direction:row; flex-wrap:nowrap; align-items:center; align-content:center; max-width:710px; overflow:auto; margin:auto; padding:10px;}
        .j-sub-link a{white-space:nowrap; text-decoration:none; padding:8px 12px; color:#000; border:1px solid #000; border-radius:20px; font-size:14px;}
        .j-sub-link a:not(:first-child){margin-left:15px;}
    </style>
</head>
<body>
    <?php require_once("../parts/headernav.php");
        echo "<h2 class='search-heading'>About $countResults product(s) found in $cat_title category</h2>"; 
    ?>

    <div class="j-sub-link">
    <?php
        switch ($_cat) {
            case 'h_h_w':
                echo "<a href='category.php?cat=all'>All</a> <a href='category.php?cat=f_w'>Foreign wigs</a> <a href='category.php?cat=h_a_c'>Hair accessories/cosmetics</a> <a href='category.php?cat=others'>Others</a>";
                break;
            case 'f_w':
                echo "<a href='category.php?cat=all'>All</a> <a href='category.php?cat=h_h_w'>100% human hair weaves</a> <a href='category.php?cat=h_a_c'>Hair accessories/cosmetics</a> <a href='category.php?cat=others'>Others</a>";
                break;
            case 'h_a_c':
                echo "<a href='category.php?cat=all'>All</a> <a href='category.php?cat=h_h_w'>100% human hair weaves</a> <a href='category.php?cat=f_w'>Foreign wigs</a> <a href='category.php?cat=others'>Others</a>";
                break;
            case 'others':
                echo "<a href='category.php?cat=all'>All</a> <a href='category.php?cat=h_h_w'>100% human hair weaves</a> <a href='category.php?cat=f_w'>Foreign wigs</a> <a href='category.php?cat=h_a_c'>Hair accessories/cosmetics</a>";
                break;
            default:
                echo "<a href='category.php?cat=h_h_w'>100% human hair weaves</a> <a href='category.php?cat=f_w'>Foreign wigs</a> <a href='category.php?cat=h_a_c'>Hair accessories/cosmetics</a> <a href='category.php?cat=others'>Others</a>";
                break;
        }
    ?>
    </div>

    <div class="container-fluid">
        <div class="row" id="pageData">
            <?php
                if($countResults < 1){                
                    echo "<h2 class='col-12 empty-section-msg'>There are no products available in this category.</h2>";
                }
            ?>
        </div>
    </div>

    <button class="load-more-btn" id="loadmorebtn">Load more</button>

    <?php require_once("../parts/footer.php"); ?>

    <script>
        var mypage = 1;
        var product_cat = "<?php echo $cat_stmt; ?>";

        mycontent(mypage, product_cat);

        $('#loadmorebtn').click(function(e){
            mypage++;
            mycontent(mypage, product_cat);
        });

        function mycontent(mypage, product_cat){
            $('#loadmorebtn').text("Loading...")
            $.post('fetch_category.php', {page:mypage, category:product_cat}, function(data){
                $('#loadmorebtn').text("Load more");
                if(data.trim().length == 0){
                    $('#loadmorebtn').text("No more posts").prop('disabled', true).css('cursor', "not-allowed");
                }
                $('#pageData').append(data);
            });
        }
    </script>

    <script src="../assets/js/script.js"></script>
</body>
</html>