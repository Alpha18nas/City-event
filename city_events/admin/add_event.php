<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];

    // رفع الصورة
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../assets/img/";
        $image = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    $sql = "INSERT INTO events (title, description, category, location, event_date, image)
            VALUES ('$title', '$description', '$category', '$location', '$event_date', '$image')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert alert-success text-center'>✅ تم إضافة الفعالية بنجاح!</div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>❌ خطأ أثناء الإضافة: {$conn->error}</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إضافة فعالية جديدة</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">إضافة فعالية</a>
      <a href="dashboard.php" class="btn btn-secondary btn-sm">⬅️ رجوع</a>
    </div>
  </nav>

  <div class="container mt-4">
    <?= $message ?>
    <div class="card p-4 shadow-sm">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">عنوان الفعالية</label>
          <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">الوصف</label>
          <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">التصنيف</label>
          <select name="category" class="form-select" required>
            <option value="">اختر التصنيف</option>
            <option value="ثقافة">ثقافة</option>
            <option value="رياضة">رياضة</option>
            <option value="موسيقى">موسيقى</option>
            <option value="عائلي">عائلي</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">المكان</label>
          <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">تاريخ الفعالية</label>
          <input type="date" name="event_date" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">صورة الفعالية</label>
          <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100">💾 حفظ الفعالية</button>
      </form>
    </div>
  </div>

</body>
</html>