<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';
$result = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>لوحة التحكم</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">لوحة التحكم</a>
      <div>
        <a href="add_event.php" class="btn btn-success btn-sm">➕ إضافة فعالية</a>
        <a href="logout.php" class="btn btn-danger btn-sm">تسجيل الخروج</a>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <h4 class="mb-3">قائمة الفعاليات</h4>
    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>العنوان</th>
          <th>التصنيف</th>
          <th>المكان</th>
          <th>التاريخ</th>
          <th>الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['title'] ?></td>
          <td><?= $row['category'] ?></td>
          <td><?= $row['location'] ?></td>
          <td><?= $row['event_date'] ?></td>
          <td>
            <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">تعديل</a>
            <a href="delete_event.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</body>
</html>