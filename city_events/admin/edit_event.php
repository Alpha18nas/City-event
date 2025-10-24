<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';
$message = '';

// جلب بيانات الفعالية للتعديل
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM events WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $event = $result->fetch_assoc();
    } else {
        die("❌ الفعالية غير موجودة");
    }
}

// عند الضغط على زر الحفظ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $image = $event['image']; // الصورة القديمة افتراضياً

    // إذا رفع صورة جديدة
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../assets/img/";
        $image = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    $update = "UPDATE events 
               SET title='$title', description='$description', category='$category',
                   location='$location', event_date='$event_date', image='$image'
               WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        $message = "<div class='alert alert-success text-center'>✅ تم تعديل الفعالية بنجاح!</div>";
        // جلب البيانات الجديدة بعد التعديل
        $event = ['title'=>$title, 'description'=>$description, 'category'=>$category,
                  'location'=>$location, 'event_date'=>$event_date, 'image'=>$image];
    } else {
        $message = "<div class='alert alert-danger text-center'>❌ خطأ أثناء التعديل: {$conn->error}</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل فعالية</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand">تعديل فعالية</a>
    <a href="dashboard.php" class="btn btn-secondary btn-sm">⬅️ رجوع</a>
  </div>
</nav>

<div class="container mt-4">
  <?= $message ?>
  <div class="card p-4 shadow-sm">
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">عنوان الفعالية</label>
        <input type="text" name="title" class="form-control" value="<?= $event['title'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">الوصف</label>
        <textarea name="description" class="form-control" rows="4" required><?= $event['description'] ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">التصنيف</label>
        <select name="category" class="form-select" required>
          <?php
          $cats = ['ثقافة','رياضة','موسيقى','عائلي'];
          foreach ($cats as $cat) {
              $sel = ($cat == $event['category']) ? 'selected' : '';
              echo "<option value='$cat' $sel>$cat</option>";
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">المكان</label>
        <input type="text" name="location" class="form-control" value="<?= $event['location'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">تاريخ الفعالية</label>
        <input type="date" name="event_date" class="form-control" value="<?= $event['event_date'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">الصورة الحالية:</label><br>
        <img src="../assets/img/<?= $event['image'] ?>" width="120" class="rounded mb-2">
        <input type="file" name="image" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary w-100">💾 حفظ التعديلات</button>
    </form>
  </div>
</div>

</body>
</html>