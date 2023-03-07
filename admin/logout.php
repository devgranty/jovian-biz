<?php
session_start();

session_unset();

session_destroy();

//init variable
$page_title = "logout";

header("Location: login.php");

