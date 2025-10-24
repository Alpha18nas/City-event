<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "city_events";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("❌ فشل الاتصال بـ MySQL: " . $conn->connect_error);
}

$sql = "
CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE $dbname;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    category VARCHAR(50),
    location VARCHAR(100),
    event_date DATE,
    image VARCHAR(255)
);

INSERT INTO users (username, password)
SELECT 'admin', MD5('admin')
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username='admin');
";

if ($conn->multi_query($sql)) {
    echo "<h2>✅ تم إنشاء قاعدة البيانات والجداول بنجاح!</h2>";
} else {
    echo "❌ خطأ أثناء إنشاء القاعدة: " . $conn->error;
}

$conn->close();
?>