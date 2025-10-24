<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

// تأكد أن الـ id واصل بالرابط
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // حذف الفعالية من القاعدة
    $sql = "DELETE FROM events WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?msg=deleted");
        exit();
    } else {
        echo "<h3 style='color:red; text-align:center; margin-top:50px;'>❌ خطأ أثناء الحذف: {$conn->error}</h3>";
    }
} else {
    echo "<h3 style='color:red; text-align:center; margin-top:50px;'>⚠️ لم يتم تحديد فعالية للحذف.</h3>";
}
?>