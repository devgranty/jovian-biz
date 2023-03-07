<?php
$page = "";

//conn to db
require_once("../connection/db_conn.php");

if(isset($_GET["query"]) && !empty($_GET["query"])){
    $search_query = filter_var($_GET["query"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $search_query = trim(strip_tags(stripslashes($search_query)));
    $count_query = count(str_split($search_query));

    if($count_query < 1 || $count_query > 70){
        $encode_errmsg = urlencode("The page you are trying to view is feeling a little bit empty. Your search query should not be empty.");
        header("Location: index.php?err=$encode_errmsg");
        exit();
    }else{
        $fetch_page = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_name LIKE '%$search_query%'");
        $fetch_page->execute();
        $count_results = $fetch_page->rowCount();
    }

}else{
    $encode_errmsg = urlencode("The page you are trying to view is feeling a little bit empty. Your search query should not be empty.");
    header("Location: index.php?err=$encode_errmsg");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $search_query; ?> &#124; Jovianbiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="stylesheet" href="../assets/css/jovianhair-style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-grid.min.css"/>
    <link rel="icon" href="../favicon.png" sizes="32x32" type="image/png">
    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
    <meta name="theme-color" content="#00a1ff">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
</head>
<body>
    <?php require_once("../parts/headernav.php");
        echo "<h2 class='search-heading'>$count_results result(s) found for $search_query</h2>";
    ?>

    <div class="container-fluid">
        <div class="row" id="pageData">
            <?php
                if($count_results < 1){                
                    echo "<h2 class='col-12 empty-section-msg'>There are no products available for this query. Try searching with shorter queries. <br> For example: Instead of \"Long hair\" you can search for \"Long\".</h2>";
                }
            ?>
        </div>
    </div>

    <button class="load-more-btn" id="loadmorebtn">Load more</button>

    <?php require_once("../parts/footer.php"); ?>

    <script>
        var mypage = 1;
        var query = "<?php echo $search_query; ?>";

        mycontent(mypage, query);

        $('#loadmorebtn').click(function(e){
            mypage++;
            mycontent(mypage, query);
        });

        function mycontent(mypage, query){
            $('#loadmorebtn').text("Loading...")
            $.post('fetch_results.php', {page:mypage, query:query}, function(data){
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