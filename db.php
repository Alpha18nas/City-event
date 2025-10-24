<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "127.0.0.1"; 
$username = "root";
$password = "";
$dbname = "city_events";

// تجربة الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

