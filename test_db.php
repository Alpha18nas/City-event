<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '/db.php';

if ($conn) {
    echo "<h2>✅ الاتصال بقاعدة البيانات شغال!</h2>";
} else {
    echo "<h2>❌ الاتصال فشل!</h2>";
}
?>