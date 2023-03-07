<?php
session_start();

if(!isset($_SESSION["uid"])){
    header("Location: login.php");
}

//init vars
$__MSG = "";

//conn to db
require_once("../connection/db_conn.php");

if(isset($_GET["stat"]) && !empty($_GET["stat"])){
    $__MSG = $_GET["stat"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/jovianhair-style.css" />
    <link rel="icon" href="../favicon.png" sizes="32x32" type="image/png">
    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hair Table &#124; Jovianbiz</title>
    <meta name="theme-color" content="#00a1ff">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<?php require_once("parts/headernav.php"); 
    if(!empty($__MSG)){
        echo "<div class='site-msg'>$__MSG</div>";
    }
?>
<h2 class="page-heading">Hair Table</h2>

<table class="results">
    <tr><th>Product ID</th><th>Edit</th><th>Product Name</th><th>Tag</th><th>Price</th><th>Availability</th><th>Description</th><th>Date/Time</th><th>Action</th></tr>
</table>

<button class="load-more-btn" id="loadmorebtn">Load more</button>

    <script>
        var mypage = 1;

        mycontent(mypage);

        $('#loadmorebtn').click(function(e){
            mypage++;
            mycontent(mypage);
        });

        function mycontent(mypage){
            $('#loadmorebtn').text("Loading...")
            $.post('fetch_table.php', {page:mypage}, function(data){
                $('#loadmorebtn').text("Load more");
                if(data.trim().length == 0){
                    $('#loadmorebtn').text("No more data").prop('disabled', true).css('cursor', "not-allowed");
                }
                $('.results').append(data);
            });
        }
    </script>

    <script src="../assets/js/script.js"></script>
</body>
</html>