<?php
$perpage = 10;

//conn to db
require_once("../connection/db_conn.php");

$numpage = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

if(!is_numeric($numpage)){
	header("HTTP/1.1 500 Invalid page number");
	exit();
}

$limit = (($numpage - 1) * $perpage);
$fetch_hair_table = $conn->prepare("SELECT pid, product_name, product_tag, product_availability, product_price, product_desc, date_time FROM _jb_hair_post ORDER BY pid DESC LIMIT $limit, $perpage");
$fetch_hair_table->execute();

while($rows = $fetch_hair_table->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td>$rows[pid]</td><td><a href='hair-edit.php?pid=$rows[pid]&type=jh'>Edit</a></td><td>$rows[product_name]</td><td>$rows[product_tag]</td><td>$rows[product_price]</td><td>$rows[product_availability]</td><td>$rows[product_desc]</td><td>$rows[date_time]</td><td><a href='delete.php?pid=$rows[pid]&type=jh'>Delete</a></td></tr>";
}
?>