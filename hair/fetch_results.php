<?php
$perpage = 8;

//conn to db
require_once("../connection/db_conn.php");

$numpage = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$query = $_POST["query"];

if(!is_numeric($numpage)){
	header("HTTP/1.1 500 Invalid page number");
	exit();
}

$limit = (($numpage - 1) * $perpage);
$fetch_page = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_img_1 FROM _jb_hair_post WHERE product_name LIKE '%$query%' ORDER BY pid DESC LIMIT $limit, $perpage");
$fetch_page->execute();

while($rows = $fetch_page->fetch(PDO::FETCH_ASSOC)){
	$db_pid = $rows["pid"];
	$db_product_name = $rows["product_name"];
	$db_product_tag = $rows["product_tag"];
	$db_product_availability = $rows["product_availability"];
	$db_product_price = $rows["product_price"];
	$db_product_image = $rows["product_img_1"];
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
?>