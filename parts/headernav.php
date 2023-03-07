<?php
if($page !== "jovian-hair-home"){
    $sideNav = "<i class='fa fa-arrow-left fa-2x headernav-navbtns' style='left:10px;' onclick='goBack()'></i>";
}else{
    $sideNav = "<i class='fa fa-bars fa-2x headernav-navbtns' style='left:10px;' onclick='openNav()'></i>";
}
?>

<div class="headernav">
    <?php echo $sideNav; ?>
    <div class="sitename"><a href="../index.php">Jovianbiz</a></div>
    <i class="fa fa-search fa-2x headernav-navbtns" style="right:18px;" onclick="openSearchBar()"></i>

    <form action="results.php" method="get" enctype="multipart/form-data" id="j-search-site" class="search-bar" style="display:none;">
        <a href="javascript:void(0)" id="closebtn" onclick="closeSearchBar()" title="Close" style="left:5px;">&times;</a>
        <input type="search" name="query" maxlength="70" placeholder="Search a product..." required/>
    </form>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" id="closebtn" onclick="closeNav()" title="Close" style="right:10px;">&times;</a>

    <h2 class="sidenav-sub-heading">Jovian Hair</h2>

    <ul class="sidenav-ul">
        <li><a href="category.php?cat=h_h_w">100% human hair weaves</a></li>
        <li><a href="category.php?cat=f_w">Foreign wigs(human hair/fibre)</a></li>
        <li><a href="category.php?cat=h_a_c">Hair accessories/cosmetics</a></li>
        <li><a href="category.php?cat=others">Others</a></li>
    </ul>
</div>